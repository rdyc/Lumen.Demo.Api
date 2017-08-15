<?php

namespace App\Repositories;

use App\Models\SyncModel;
use App\Repositories\Contracts\ISyncRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class SyncRepository extends GenericRepository implements ISyncRepository
{

    public function __construct()
    {
        parent::__construct(App::make(SyncModel::class));
    }


    /**
     * @param $client
     * @return null|\App\Models\SyncClientModel
     */
    public function getLatest($client = null)
    {
        $result = null;

        if($result){
            $result = $this->model->where('updated_at', '>', $client->updated_at)->orderBy('updated_at', 'desc')->get();
        }else{
            $result = $this->model->orderBy('updated_at', 'desc')->first();
        }

        return $result;
    }

    /**
     * @param $date \Carbon\Carbon
     * @return integer
     */
    public function count($date)
    {
        //$_date = Carbon::parse($date);
        $date = Carbon::parse($date);

        return $this->model
            ->where('created_at', '>', $date->format('Y-m-d'))
            ->where('created_at', '<', $date->addDay(1)->format('Y-m-d'))
            ->count();
    }

    public function store(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function getSince($version)
    {
        $result = null;

        if($version){
            $version = $this->model->where('sync_version', $version)->firstOrFail();
            //print_r(Carbon::parse($version->created_at)->toDateTimeString());exit;
            $result = $this->model->where('created_at', '>', Carbon::parse($version->created_at)->toDateTimeString())->get();
        }else{
            $result = $this->model->get();
        }

        return $result;
    }
}