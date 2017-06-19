<?php

namespace App\Models;

class Song extends BaseModel
{
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
    protected $table = 'songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'track', 'title', 'album_id', 'active', 'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany('App\Models\Album', 'id', 'album_id');
    }

}
