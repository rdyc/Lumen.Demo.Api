<?php

namespace App\Models;

use App\Models\BaseModel;

class DocumentModel extends BaseModel
{
    /**
     * The connection name for the model.
     * todo: please change the connection name
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     * todo: please change the table name
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The primary key for the model.
     * todo: please change the primary key column
     *
     * @var string
     */
    protected $primaryKey = 'document_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * todo: please change the increment status
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
        'document_name',
        'document_mime',
        'document_size',
        'document_content',
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
        'document_size' => 'integer',
    ];

    /** 
     * Override default sort direction
     *  @var string
     */
    protected $defaultSort = 'asc';

    public static function getDocumentContentAttribute($value)
    {
        return utf8_encode($value);
    }
    
}
