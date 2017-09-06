<?php

namespace App\Services\Synchronize;

use App\Repositories\Contracts\Synchronize\ISyncStoragePushRepository;
use App\Services\Contracts\Synchronize\ISyncHelperService;
use App\Services\Contracts\Synchronize\ISyncMergeService;
use Illuminate\Support\Facades\Log;

class SyncMergeService implements ISyncMergeService
{
    protected $syncStoragePushRepository;
    protected $syncHelperService;

    protected $mapModels = [];
    protected $mapKeyModels = [];

    function __construct(ISyncStoragePushRepository $syncStoragePushRepository,
                         ISyncHelperService $syncHelperService)
    {
        $this->syncStoragePushRepository = $syncStoragePushRepository;
        $this->syncHelperService = $syncHelperService;

        $this->mapModels = $this->syncHelperService->populateModels();
    }

    public function start($version, $path)
    {
        if (empty($this->mapModels)) throw new \Exception('Sync merge service was unable to find synced models');
        if (!$version) throw new \Exception('Sync merge service was unable to find current version');
        if (!$path) throw new \Exception('Sync merge service was unable to find current path');

        Log::info('[Queue] Mapped synced models: ' . implode(',', array_keys($this->mapModels)));
        //Log::info('[Queue] Mapped sync keys: ' . implode(',', $this->mapKeyModels));

        $content = $this->getContent($version, $path);

        $this->execute($content);
    }

    private function getContent($version, $path)
    {
        $content = null;

        $push = $this->syncStoragePushRepository->getByVersion($version);
        $content = json_decode($push->sync_storage_content);

        if (!$content) throw new \Exception('Sync merge service was unable to get push content for version ' . $version);

        return $content;
    }

    private function execute($content)
    {
        $user = $content->user;

        // schemas
        foreach ($content->schemas as $key => $schema) {
            $table = $schema->name;

            // check schema name exists
            if (array_key_exists($table, $this->mapModels)) {
                // get key name for current schema
                $primaryKey = $this->mapModels[$table]['key'];

                // processing item
                foreach ($schema->items as $key => $value) {
                    // check primary key exists
                    if (array_key_exists($primaryKey, $value)) {
                        Log::info('[Queue] Processing "' . $table . '" at index ' . $key . ' w/ data: ' . json_encode($value));

                        // merge values
                        $attributes = array_merge((array)$value, ['created_by' => $user, 'updated_by' => $user]);

                        // do update or create
                        if(class_exists($this->mapModels[$table]['repository'], true)){
                            $repo = new $this->mapModels[$table]['repository'];
                            $repo->syncUpdateOrCreate($value->{$primaryKey}, $attributes);
                        }else{
                            Log::warning('[Queue] Unable to load class '. $this->mapModels[$table]['repository']);
                        }
                    } else {
                        Log::warning('[Queue] Schema primary key "' . $table . '.' . $primaryKey . '" was not found in push items at index ' . $key);
                    }
                }
            } else {
                Log::warning('[Queue] Schema name "' . $table . '" was not in sync models');
            }
        }
    }
}