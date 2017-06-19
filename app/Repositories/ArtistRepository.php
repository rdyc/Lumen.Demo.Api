<?php

namespace App\Repositories;

use App\Models\Artist;
use App\Repositories\Contracts\IArtistRepository;
use Illuminate\Support\Facades\App;

class ArtistRepository extends GenericRepository implements IArtistRepository
{

    public function __construct()
    {
        parent::__construct(App::make(Artist::class));
    }

    // define other methods here
}
