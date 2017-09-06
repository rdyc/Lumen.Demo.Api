<?php

namespace App\Models;

class PemasokDetailItemModel extends BaseSyncModel
{
    use UuidTrait;

    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\PemasokDetailItemRepository';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_pemasok_d_item';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'pemasok_d_item_id';

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
        'pemasok_d_id',
        'pemasok_h_id',
        'kategori_pemasok',
        'element_item_id',
        'element_id',
        'item',
        'score',
        'val',
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
        'element_item_id' => 'real',
        'element_id' => 'real',
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
