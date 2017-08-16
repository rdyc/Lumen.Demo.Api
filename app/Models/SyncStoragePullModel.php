<?php

namespace App\Models;

class SyncStoragePullModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sync_storage_pull';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sync_storage_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sync_storage_version',
        'sync_storage_content',
        'sync_storage_size',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sync_storage_size' => 'integer'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'desc';
    
}
