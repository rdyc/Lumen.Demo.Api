<?php

namespace App\Services\Synchronize;

use App\Http\Requests\SyncPatchRequest;
use App\Jobs\SyncPushProcessorJob;
use App\Models\BaseSyncModel;
use App\Repositories\Contracts\Synchronize\ISyncClientRepository;
use App\Repositories\Contracts\Synchronize\ISyncPullRepository;
use App\Repositories\Contracts\Synchronize\ISyncPushRepository;
use App\Repositories\Contracts\Synchronize\ISyncStoragePullRepository;
use App\Repositories\Contracts\Synchronize\ISyncStoragePushRepository;
use App\Services\Contracts\Synchronize\ISyncHelperService;
use App\Services\Contracts\Synchronize\ISyncManagerService;
use App\Services\Contracts\Synchronize\ISyncMergeService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SyncManagerService implements ISyncManagerService
{
    protected $syncPullRepo;

    protected $syncPushRepo;

    protected $syncClientRepo;

    protected $syncStoragePullRepo;

    protected $syncStoragePushRepo;

    protected $syncMergeService;

    protected $syncHelperService;

    function __construct(ISyncPullRepository $syncRepository,
                         ISyncPushRepository $syncPushRepository,
                         ISyncClientRepository $syncClientRepository,
                         ISyncStoragePullRepository $syncStoragePullRepository,
                         ISyncStoragePushRepository $syncStoragePushRepository,
                         ISyncMergeService $mergeService,
                         ISyncHelperService $helperService)
    {
        $this->syncPullRepo = $syncRepository;
        $this->syncPushRepo = $syncPushRepository;
        $this->syncClientRepo = $syncClientRepository;
        $this->syncStoragePullRepo = $syncStoragePullRepository;
        $this->syncStoragePushRepo = $syncStoragePushRepository;
        $this->syncMergeService = $mergeService;
        $this->syncHelperService = $helperService;
    }

    // Public Methods ---------------

    public function get($page, $limit, $order, $sort)
    {
        return $this->syncPullRepo->get($page, $limit, $order, $sort);
    }

    public function getSyncedModels()
    {
        return json_decode(json_encode($this->syncHelperService->populateModels()));
    }

    public function latest($payload, $user)
    {
        $client = $this->storeLog($payload, $user);

        return $this->searchLatest($client);
    }

    public function track($user)
    {
        $version = $this->syncPullRepo->getLatest();

        // assign default date when latest version not exists
        $now = $version ? $version->updated_at : Carbon::parse('1970-01-01 00:00:00');

        // prepare new version number
        $version = $this->generateVersion();

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

            return $this->syncPullRepo->store($sync);
        } else {
            return null;
        }
    }

    public function pull($payload, $user)
    {
        $result = null;

        $syncs = $this->syncPullRepo->getSince($payload->version);

        if (count($syncs) > 0) {
            // visible path
            $syncs = $syncs->makeVisible('sync_path')->toArray();

            $changes = [];

            foreach ($syncs as $item) {
                // restore from db if local json file was deleted
                if (!file_exists($item['sync_path'])) {
                    $storage = $this->syncStoragePullRepo->getByVersion($item['sync_version']);

                    $this->saveIntoFileStorage($item['sync_version'], $storage->sync_storage_content, config('sync.storage.pull.path'));
                }

                // get local file
                $content = file_get_contents($item['sync_path']);

                if (!$content) {
                    throw new \Exception('Unable to get synchronization data for version ' . $item['sync_version']);
                }

                // decode into json
                $json = json_decode($content);

                // push data into array
                $changes[] = $json->data;
            }

            $result = [
                'data' => [
                    'total' => count($changes),
                    'changes' => $changes
                ]
            ];
        }

        return $result;
    }

    public function push($payload, $user)
    {
        // check current version is in behind or not?
        if (count($this->syncPullRepo->getSince($payload->version)) != 1)
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Your local version is in behind, try to pull first!');

        // flatten schema rows
        $content = $this->parseRows($payload, $user);

        // generate new version
        $version = $this->generateVersion('push');

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

        // insert sync queue jobs
        $this->addToQueue($version, $path);

        return $content;
    }

    // Private Methods ----------------

    private function storeLog($attributes, $user)
    {
        return $this->syncClientRepo->storeLog($attributes, $user);
    }

    private function searchLatest($client)
    {
        return $this->syncPullRepo->getLatest($client);
    }

    private function saveIntoFileStorage($version, $content, $storagePath)
    {
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

    /**
     * @param $payload SyncPatchRequest
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

    private function generateVersion($mode = 'pull')
    {
        $carbon = Carbon::now();

        $version_count = $mode == 'pull' ? $this->syncPullRepo->count($carbon) : $this->syncPushRepo->count($carbon);
        $version_prefix = $carbon->format('ymd');
        $version_len = (int)(log($version_count, 10) + 1);
        $version_seq = str_repeat('0', (4 - ($version_len == 0 ? ($version_len + 1) : $version_len))) . ($version_count + 1);
        $version_new = $version_prefix . '-' . $version_seq;

        return $version_new;
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

    private function addToQueue($version, $path)
    {
        $data = [
            'version' => $version,
            'path' => $path
        ];

        $job = new SyncPushProcessorJob($this->syncMergeService, $data);

        Queue::push($job);
    }

    private function prepareData($version, $carbon, $user)
    {
        $carbon = Carbon::parse($carbon);

        $schemas = null;

        // get all sync classes
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseSyncModel::class)) {
                $model = new $class;
                $items = $model->getChanges($carbon);

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
}