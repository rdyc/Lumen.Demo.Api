<?php

namespace App\Models;

class Album extends BaseModel
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
    protected $table = 'albums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artist_id', 'title', 'released', 'active', 'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function artist()
    {
        return $this->hasOne(Artist::class, 'id', 'artist_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs()
    {
        return $this->hasMany(Song::class, 'album_id');
    }
}
