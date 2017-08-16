<?php

namespace App\Services;

use App\Http\Requests\SyncPostRequest;
use App\Jobs\SyncPushProcessorJob;
use App\Models\BaseSyncModel;
use App\Repositories\Contracts\ISyncClientRepository;
use App\Repositories\Contracts\ISyncPushRepository;
use App\Repositories\Contracts\ISyncRepository;
use App\Repositories\Contracts\ISyncStoragePullRepository;
use App\Repositories\Contracts\ISyncStoragePushRepository;
use App\Services\Contracts\ISyncService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Queue;

class SyncService implements ISyncService
{
    protected $syncRepo;

    protected $syncPushRepo;

    protected $syncClientRepo;

    protected $syncStoragePullRepo;

    protected $syncStoragePushRepo;

    function __construct(ISyncRepository $syncRepository,
                         ISyncPushRepository $syncPushRepository,
                         ISyncClientRepository $syncClientRepository,
                         ISyncStoragePullRepository $syncStoragePullRepository,
                         ISyncStoragePushRepository $syncStoragePushRepository)
    {
        $this->syncRepo = $syncRepository;
        $this->syncPushRepo = $syncPushRepository;
        $this->syncClientRepo = $syncClientRepository;
        $this->syncStoragePullRepo = $syncStoragePullRepository;
        $this->syncStoragePushRepo = $syncStoragePushRepository;
    }

    // Public Methods ---------------

    public function get($page, $limit, $order, $sort)
    {
        return $this->syncRepo->get($page, $limit, $order, $sort);
    }

    public function latest($payload, $user)
    {
        $client = $this->storeLog($payload, $user);

        return $this->searchLatest($client);
    }

    public function pull($payload, $user)
    {
        $result = null;

        $changes = $this->syncRepo->getSince($payload->version);

        if(count($changes) > 0){
            // visible path
            $changes = $changes->makeVisible('sync_path')->toArray();

            $jsonArray = [];

            foreach ($changes as $item){
                // restore from db if local json file was deleted
                if(!file_exists($item['sync_path'])){
                    $storage = $this->syncStoragePullRepo->getByVersion($item['sync_version']);

                    $this->saveIntoFileStorage($item['sync_version'], $storage->sync_storage_content, config('sync.storage.pull.path'));
                }

                // get local file
                $content = file_get_contents($item['sync_path']);

                if(!$content){
                    throw new \Exception('Unable to get synchronization data for version '. $item['sync_version']);
                }

                // decode into json
                $json = json_decode($content);

                // push data into array
                $jsonArray[] = $json->data;
            }

            //print_r($jsonArray);exit;

            $result = [
                'data' => [
                    'total' => count($jsonArray),
                    'changeset' => $jsonArray
                ]
            ];
        }

        return $result;
    }

    public function push($payload, $user)
    {
        // flatten schema rows
        $content = $this->parseRows($payload, $user);

        //print_r($sync);exit;

        // generate new version
        $version = $this->generateVersion('push');
        //print_r(config('sync.storage.push.path'));exit;

        // encode as json
        $json = json_encode($content);

        // store json in local storage
        $path = $this->saveIntoFileStorage($version, $json, config('sync.storage.push.path'));

        // store json in db for backup purpose
        $this->savePushIntoDbStorage($version, filesize($path), $json, $user);

        // store push log into db
        $this->syncPushRepo->store([
            'sync_version' => $version,
            'sync_client' => $_SERVER['REMOTE_ADDR'],
            'sync_size' => filesize($path),
            'sync_path' => $path,
            'sync_is_complete' => false,
            'created_by' => $user->email,
            'updated_by' => $user->email,
        ]);

        // insert syn queue jobs
        $job = (new SyncPushProcessorJob(
            [
                'version' => $version,
                'sync_path' => $path
            ]))
            ->onQueue('processing')
            ->delay(Carbon::now()->addSecond(10));

        dispatch($job);

        return $content;
    }

    public function track($user)
    {
        // TODO: Dummy process
        $version = $this->syncRepo->getLatest();

        $now = $version ? $version->updated_at : Carbon::parse('1970-01-01 00:00:00');
        //print_r($now);exit;

        //$now = Carbon::Now()->addDay(-1);

        // prepare new version number
        $version = $this->generateVersion();
        //print_r($version_new);exit;

        // prepare data changes
        $path = $this->prepareData($version, $now, $user);

        if ($path) {
            $sync = [
                'sync_version' => $version,
                'sync_client' => $_SERVER['REMOTE_ADDR'],
                'sync_size' => filesize($path),
                'sync_path' => $path,
                'created_by' => $user->email,
                'updated_by' => $user->email,
            ];

            return $this->syncRepo->store($sync);
        } else {
            return null;
        }
    }

    // Private Methods ----------------

    private function searchLatest($client)
    {
        return $this->syncRepo->getLatest($client);
    }

    private function storeLog($attributes, $user)
    {
        return $this->syncClientRepo->storeLog($attributes, $user);
    }

    private function generateVersion($mode = 'pull')
    {
        $carbon = Carbon::now();
        //print_r(Carbon::parse($carbon));exit;

        $version_count = $mode == 'pull' ? $this->syncRepo->count($carbon) : $this->syncPushRepo->count($carbon);
        $version_prefix = $carbon->format('ymd');
        $version_len = (int)(log($version_count, 10) + 1); //print_r($version_len);exit;
        $version_seq = str_repeat('0', (4 - ($version_len == 0 ? ($version_len + 1) : $version_len))) . ($version_count + 1);
        $version_new = $version_prefix . '-' . $version_seq;

        return $version_new;
    }

    private function prepareData($version, $carbon, $user)
    {
        $carbon = Carbon::parse($carbon);

        $schemas = null;

        // load classes
        App::make(\App\Models\GeneralDataModel::class);
        App::make(\App\Models\ElementFormModel::class);
        App::make(\App\Models\ElementItemModel::class);
        App::make(\App\Models\ValidationRuleModel::class);
        App::make(\App\Models\MatrixElementModel::class);

        // get all sync classes
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseSyncModel::class)) {
                $model = new $class;
                $items = $model->getChanges($carbon);
                //print_r($items->toArray());exit;

                if (count($items) > 0) {
                    if (!is_array($schemas)) $schemas = [];

                    $schemas[] = [
                        'name' => $model->getTable(),
                        'total' => count($items),
                        'items' => count($items) == 0 ? null : $items->toArray()
                    ];
                }
            }
        }

        //print_r($schemas);exit;

        //$generals = $this->masterGeneralRepository->all($carbon);

        // skip if no changes
        if ($schemas) {
            $result = [
                'data' => [
                    'version' => $version,
                    'timestamp' => $carbon->now()->format('c'),
                    'schemas' => $schemas
                ]
            ];

            // encode as json
            $json = json_encode($result);

            // store json in local storage
            $path = $this->saveIntoFileStorage($version, $json, config('sync.storage.pull.path'));

            // store json in db for backup purpose
            $this->savePullIntoDbStorage($version, filesize($path), $json, $user);

            return $path;
        } else {
            return null;
        }
    }

    private function saveIntoFileStorage($version, $content, $storagePath){
        $ver = explode('-', $version);
        $path = storage_path($storagePath . $ver[0] . '/' . $ver[1] . '.json');

        // create dir if not exists
        if (!file_exists(storage_path($storagePath . $ver[0]))) {
            mkdir(storage_path($storagePath . $ver[0]), 0700);
        }

        // store json in "~/storage/sync/pull/yymmdd/xxxx.json"
        file_put_contents($path, $content);

        return $path;
    }

    private function savePullIntoDbStorage($version, $size, $content, $user)
    {
        $this->syncStoragePullRepo->create([
           'sync_storage_version' => $version,
           'sync_storage_size' => $size,
           'sync_storage_content' => $content,
           'created_by' => $user->email,
           'updated_by' => $user->email,
        ]);
    }

    private function savePushIntoDbStorage($version, $size, $content, $user)
    {
        $this->syncStoragePushRepo->create([
            'sync_storage_version' => $version,
            'sync_storage_size' => $size,
            'sync_storage_content' => $content,
            'created_by' => $user->email,
            'updated_by' => $user->email,
        ]);
    }

    /**
     * @param $payload SyncPostRequest
     * @return array
     */
    private function parseRows($payload, $user)
    {
        $entities = [];

        // schemas
        foreach ($payload->schemas as $schema) {
            $schemas = [];

            // rows
            foreach ($schema->rows as $row) {
                $rows = [];

                // row
                foreach ($row as $column) {

                    // columns
                    foreach ($column as $field) {

                        // fields
                        $rows[$field->column] = $field->value;
                    }
                }

                $schemas[] = $rows;
            }

            $entities[] = [
                'name' => $schema->name,
                'total' => count($schemas),
                'items' => $schemas
            ];
        }

        $result = [
            'user' => $user->email,
            'client' => $payload->client,
            'version' => $payload->version,
            'total' => count($entities),
            'schemas' => $entities
        ];

        return $result;
    }
}