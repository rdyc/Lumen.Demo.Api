<?php

namespace App\Models;

class MatrixElementModel extends BaseSyncModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_matrix_element';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'matrix_element_id';

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
        'element_id',
        'kategori',
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
        'element_id' => 'integer',
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
