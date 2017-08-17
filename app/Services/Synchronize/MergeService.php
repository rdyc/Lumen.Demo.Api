<?php

namespace App\Services\Synchronize;


use App\Models\BaseSyncModel;
use App\Repositories\Contracts\IMasterGeneralRepository;
use App\Repositories\Contracts\ISyncStoragePushRepository;
use App\Services\Contracts\Synchronize\IMergeService;
use Illuminate\Support\Facades\Log;

class MergeService implements IMergeService
{

    protected $generalRepository;
    protected $syncStoragePushRepository;

    protected $mapModels = [];
    protected $mapKeyModels = [];

    function __construct(IMasterGeneralRepository $generalRepository, ISyncStoragePushRepository $syncStoragePushRepository)
    {
        $this->generalRepository = $generalRepository;
        $this->syncStoragePushRepository = $syncStoragePushRepository;

        $this->populateSyncModels();
    }

    private function populateSyncModels()
    {
        // get all sync classes
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseSyncModel::class)) {
                $model = new $class;

                $table = $model->getTable();

                if (!array_key_exists($class, $this->mapModels))
                    $this->mapModels[$table] = $class;

                if (!array_key_exists($table, $this->mapKeyModels))
                    $this->mapKeyModels[$table] = $model->getKeyName();
            }
        }
    }

    public function start($version, $path)
    {
        if (empty($this->mapModels)) throw new \Exception('Sync merge service was unable to find sync models');
        if (!$version) throw new \Exception('Sync merge service was unable to find current version');
        if (!$path) throw new \Exception('Sync merge service was unable to find current path');

        Log::info('[Queue] Mapped sync models: ' . implode(',', $this->mapModels));
        Log::info('[Queue] Mapped sync keys: ' . implode(',', $this->mapKeyModels));

        $content = $this->getContent($version, $path);

        $this->execute($content);
    }

    private function getContent($version, $path)
    {
        $content = null;

        /*if (file_exists($path)) {
            $content = json_decode(file_get_contents($path));
        } else {
            $content = $this->syncStoragePushRepository->getByVersion($version);
        }*/

        $push = $this->syncStoragePushRepository->getByVersion($version);
        $content = json_decode($push->sync_storage_content);

        if (!$content) throw new \Exception('Sync merge service was unable to get push content for version ' . $version);

        return $content;
    }

    private function execute($content)
    {
        // schemas
        foreach ($content->schemas as $key => $schema) {
            $table = $schema->name;

            // check schema name exists
            if (array_key_exists($table, $this->mapModels)) {
                // get key name for current schema
                $primaryKey = $this->mapKeyModels[$table];

                // processing item
                foreach ($schema->items as $key => $value) {
                    // check primary key exists
                    if (array_key_exists($primaryKey, $value)) {
                        Log::info('[Queue] Processing "' . $table . '" at index ' . $key . ' w/ data: ' . json_encode($value));

                        // do update or create
                        $this->updateOrCreate($table, $value->{$primaryKey}, (array)$value);
                    } else {
                        Log::warning('[Queue] Schema primary key "' . $table . '.' . $primaryKey . '" was not found in push items at index ' . $key);
                    }
                }

                //$this->yowMbuh($schema->rows);
            } else {
                Log::warning('[Queue] Schema name "' . $table . '" was not in sync models');
            }
        }
    }

    private function updateOrCreate($table, $id, $value)
    {
        switch ($table) {
            case 'tm_general_data';
                $this->generalRepository->syncUpdateOrCreate($id, $value);
                break;
        }
    }
}