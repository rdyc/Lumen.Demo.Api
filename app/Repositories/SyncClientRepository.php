<?php

namespace App\Repositories;

use App\Models\SyncClientModel;
use App\Repositories\Contracts\ISyncClientRepository;
use App\Repositories\Contracts\ISyncRepository;
use Illuminate\Support\Facades\App;

class SyncClientRepository extends GenericRepository implements ISyncClientRepository
{
    public function __construct(ISyncRepository $syncRepository)
    {
        parent::__construct(App::make(SyncClientModel::class));
    }

    public function storeLog($attributes, $user)
    {
        $client = $this->model->where('sync_client_identifier', $attributes->client)->first();

        if ($client) {
            $sync = [
                'sync_client_version' => $attributes->version,
                'updated_by' => $user->email
            ];

            $client->update($sync);
        } else {
            $sync = [
                'sync_client_identifier' => $attributes->client,
                'sync_client_version' => $attributes->version,
                'created_by' => $user->email,
                'updated_by' => $user->email
            ];

            $client = $this->model->create($sync);
        }

        return $client;
    }
}