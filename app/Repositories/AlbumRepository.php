<?php

namespace App\Repositories;

use App\Models\Album;
use App\Repositories\Contracts\IAlbumRepository;
use Illuminate\Support\Facades\App;

class AlbumRepository extends GenericRepository implements IAlbumRepository
{

    public function __construct()
    {
        parent::__construct(App::make(Album::class));
    }

    // define other methods here
}
