<?php

namespace App\Models;

class SyncModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_sync_version';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'version';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version',
        'source',
        'size',
        'path',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'size' => 'integer'
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'desc';
    
}
