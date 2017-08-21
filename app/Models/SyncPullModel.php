<?php

namespace App\Models;

class SyncPullModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sync_pull';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sync_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sync_version',
        'sync_client',
        'sync_size',
        'sync_path',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sync_size' => 'integer'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'sync_path',
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'desc';
    
}
