<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends BaseModel
{
    use SoftDeletes;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql.core';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active', 'created_at', 'updated_at', 'deleted_at'
    ];

    /** Properties
     *  @var string
     */
    protected $name;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function albums()
    {
        return $this->hasMany('App\Models\Album', 'artist_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function songs()
    {
        return $this->hasManyThrough('App\Models\Song', 'App\Models\Album', 'artist_id', 'album_id');
    }

    public function onCreated(){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
        ];
    }

    public function onUpdated(){
        return [
            'id' => $this->id,
            'updated_at' => $this->updated_at,
        ];
    }

    public function onDeleted(){
        return [
            'id' => $this->id,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
