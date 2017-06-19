<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model 
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    //protected $dateFormat = 'U';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //'active'
    ];

    public function getCreatedAtAttribute($attr) {
        return Carbon::parse($attr)->format('c');
    }

    public function getUpdatedAtAttribute($attr) {
        return Carbon::parse($attr)->format('c');
    }

    public function getDeletedAtAttribute($attr) {
        return Carbon::parse($attr)->format('c');
    }
}