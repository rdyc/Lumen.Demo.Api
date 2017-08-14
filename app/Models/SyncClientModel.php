<?php

namespace App\Models;

class SyncClientModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sync_client';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sync_client_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sync_client_identifier',
        'sync_client_version',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'sync_size' => 'integer'
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'asc';
    
}
