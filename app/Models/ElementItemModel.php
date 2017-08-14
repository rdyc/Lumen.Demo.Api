<?php

namespace App\Models;

class ElementItemModel extends BaseSyncModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tm_element_item';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'element_item_id';

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
        'item',
        'score',
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
        'element_item_id' => 'integer',
        'element_id' => 'integer',
        'score' => 'integer',
        'fl_status' => 'boolean'
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
     * @var string
     */
    protected $defaultSort = 'asc';

}
