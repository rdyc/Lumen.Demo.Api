<?php

namespace App\Repositories;

use App\Models\DocumentModel;
use App\Repositories\GenericRepository;
use App\Repositories\Contracts\IDocumentRepository;
use Illuminate\Support\Facades\App;

class DocumentRepository extends GenericRepository implements IDocumentRepository
{

    public function __construct()
    {
        parent::__construct(App::make(DocumentModel::class));
    }

    // define other methods here
}