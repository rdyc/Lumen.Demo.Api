<?php

namespace Database\Seeds;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call('ArtistTableSeeder');*/

        factory(App\Models\Artist::class, 20)->create();
        factory(App\Models\Album::class, 60)->create();
        factory(App\Models\Song::class, 200)->create();
    }
}
