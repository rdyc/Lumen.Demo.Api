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
        $client = $this->model->where('sync_client_identifier', $attributes['sync_client_identifier'])->first();

        if ($client) {
            $client->update([
                'sync_client_version' => $attributes['sync_client_version'],
                'updated_by' => $user->email
            ]);
        } else {
            $attributes['created_by'] = $user->email;
            $attributes['updated_by'] = $user->email;

            $client = $this->model->create($attributes);
        }

        return $client;
    }
}