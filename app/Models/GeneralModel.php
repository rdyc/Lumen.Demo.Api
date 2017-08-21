<?php

namespace App\Models;

class GeneralModel extends BaseSyncModel
{

    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\GeneralRepository';


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
    protected $primaryKey = 'general_data_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'general_code', 
        'description_code',
        'description',
        'initial_code',
        'color',
        'general_id',
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
        'general_data_id' => 'integer',
        'sorting' => 'integer',
        'fl_status' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_by',
        'deleted_at',
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'asc';
    
}
