<?php

namespace App\Models;

class PemasokHeaderModel extends BaseSyncModel
{
    use UuidTrait;

    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\PemasokHeaderRepository';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_pemasok_h';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'pemasok_h_id';

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
        'kode_pemasok',
        'nama_pemasok',
        'kategori_pemasok',
        'area_code',
        'no_ktp',
        'area_id',
        'device',
        'sync_version',
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
        'area_id' => 'real',
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
