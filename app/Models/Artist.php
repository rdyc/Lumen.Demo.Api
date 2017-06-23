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
    protected $connection = 'mysql';

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
        'name', 
        'active'
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'desc';

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

    
}
