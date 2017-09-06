<?php

namespace App\Models;

class PemasokDetailModel extends BaseSyncModel
{
    use UuidTrait;

    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\PemasokDetailRepository';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_pemasok_d';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'pemasok_d_id';

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
        'pemasok_h_id',
        'element_id',
        'parent_element',
        'score',
        'sorting',
        'sort_parent',
        'target_element',
        'group_element',
        'field_name',
        'field_type',
        'val',
        'url_lookup',
        'url_data_api',
        'kriteria',
        'session_data',
        'keterangan',
        'latitude',
        'longitude',
        'special_form',
        'fl_lookup',
        'fl_target',
        'fl_multiple',
        'fl_group',
        'fl_end_group',
        'fl_lampiran',
        'fl_keterangan',
        'fl_additional_data',
        'fl_reference',
        'fl_end_level',
        'fl_max_score',
        'fl_koordinat',
        'fl_data_auth',
        'fl_data_api',
        'fl_lookup_data',
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
        'element_id' => 'real',
        'parent_element' => 'real',
        'score' => 'real',
        'sorting' => 'real',
        'sort_parent' => 'real',
        'target_element' => 'real',
        'group_element' => 'real',
        'fl_lookup' => 'boolean',
        'fl_target' => 'boolean',
        'fl_multiple' => 'boolean',
        'fl_group' => 'boolean',
        'fl_end_group' => 'boolean',
        'fl_lampiran' => 'boolean',
        'fl_keterangan' => 'boolean',
        'fl_additional_data' => 'boolean',
        'fl_reference' => 'boolean',
        'fl_end_level' => 'boolean',
        'fl_max_score' => 'boolean',
        'fl_koordinat' => 'boolean',
        'fl_data_auth' => 'boolean',
        'fl_data_api' => 'boolean',
        'fl_lookup_data' => 'boolean',
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
     * @var string
     */
    protected $defaultSort = 'asc';

}
