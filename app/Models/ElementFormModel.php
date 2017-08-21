<?php

namespace App\Models;

class ElementFormModel extends BaseSyncModel
{
    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\ElementFormRepository';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tm_element_form';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'element_id';

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
        'parent_element',
        'field_name',
        'field_type',
        'special_form',
        'kriteria',
        'score',
        'sorting',
        'sort_parent',
        'group_element',
        'target_element',
        'session_data',
        'url_lookup',
        'url_data_api',
        'fl_lookup',
        'fl_lookup_data',
        'fl_target',
        'fl_multiple',
        'fl_group',
        'fl_end_group',
        'fl_lampiran',
        'fl_keterangan',
        'fl_additional_data',
        'fl_reference',
        'fl_end_level',
        'fl_status',
        'fl_max_score',
        'fl_koordinat',
        'fl_data_auth',
        'fl_data_api',
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
        'parent_element_id' => 'integer',
        'score' => 'integer',
        'sorting' => 'integer',
        'group_element' => 'integer',
        'target_element' => 'integer',
        'fl_lookup' => 'boolean',
        'fl_lookup_data' => 'boolean',
        'fl_target' => 'boolean',
        'fl_multiple' => 'boolean',
        'fl_group' => 'boolean',
        'fl_end_group' => 'boolean',
        'fl_lampiran' => 'boolean',
        'fl_keterangan' => 'boolean',
        'fl_additional_data' => 'boolean',
        'fl_reference' => 'boolean',
        'fl_end_level' => 'boolean',
        'fl_status' => 'boolean',
        'fl_max_score' => 'boolean',
        'fl_koordinat' => 'boolean',
        'fl_data_auth' => 'boolean',
        'fl_data_api' => 'boolean'
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
