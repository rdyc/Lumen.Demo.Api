<?php

namespace App\Repositories;

use App\Models\Song;
use App\Repositories\Contracts\ISongRepository;
use Illuminate\Support\Facades\App;

class SongRepository extends GenericRepository implements ISongRepository
{

    public function __construct()
    {
        parent::__construct(App::make(Song::class));
    }

    // define other methods here
}
