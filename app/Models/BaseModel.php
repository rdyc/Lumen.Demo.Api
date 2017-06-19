<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

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

    /** Default sort direction
     *  @var string
     */
    protected $defaultSort = 'asc';

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
        'deleted_at'
    ];

    public function getSortDirection()
    {
        return $this->defaultSort;
    }

    public function getCreatedAtAttribute($attr)
    {
        return $this->formatDate($attr);
    }

    public function getUpdatedAtAttribute($attr)
    {
        return $this->formatDate($attr);
    }

    public function getDeletedAtAttribute($attr)
    {
        return $this->formatDate($attr);
    }

    public function onCreated()
    {
        return [
            'id' => $this->id,
            'created_at' => $this->formatDate($this->attributes['created_at'])
        ];
    }

    public function onUpdated()
    {
        return [
            'id' => $this->id,
            'updated_at' => $this->formatDate($this->attributes['updated_at']),
        ];
    }

    public function onDeleted()
    {
        return [
            'id' => $this->id,
            'deleted_at' => $this->formatDate($this->attributes['deleted_at']),
        ];
    }

    private function formatDate($attr)
    {
        return $attr ? Carbon::parse($attr)->format('c') : null;
    }
}
