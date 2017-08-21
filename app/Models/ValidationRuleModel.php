<?php

namespace App\Models;

class ValidationRuleModel extends BaseSyncModel
{

    /**
     * Repository class name
     *
     * @var string
     */
    protected $repository = '\App\Repositories\ValidationRuleRepository';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tr_rules_validasi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'rules_validasi_id';

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
        'min_length',
        'max_length',
        'script_server',
        'script_client',
        'fl_readonly',
        'fl_display_month',
        'fl_display_year',
        'fl_related_validasi',
        'fl_reusable',
        'fl_require',
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
        'min_length' => 'integer',
        'max_length' => 'integer',
        'fl_readonly' => 'boolean',
        'fl_display_month' => 'boolean',
        'fl_display_year' => 'boolean',
        'fl_related_validasi' => 'boolean',
        'fl_reusable' => 'boolean',
        'fl_require' => 'boolean',
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
