<?php

use Illuminate\Database\Seeder;

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
