<?php

namespace app\Models;

use Webpatser\Uuid\Uuid;

trait UuidTrait
{
    /**
     *  Setup model event hooks
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Uuid::generate();
        });
    }
}