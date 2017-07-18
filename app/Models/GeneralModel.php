<?php

namespace App\Models;

use App\Models\BaseModel;

class GeneralModel extends BaseModel
{
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
    protected $table = 'tm_general_data';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'general_code';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'general_code', 
        'description_code',
        'description',
        'icon',
        'sorting',
        'fl_status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sorting' => 'integer',
        'fl_status' => 'boolean',
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'asc';
    
}
