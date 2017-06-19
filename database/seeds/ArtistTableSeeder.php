<?php

use Illuminate\Database\Seeder;

class ArtistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(App\User::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(App\Post::class)->make());
        });*/

        /*$data = [];
        for($i=1;$i<100;$i++){
            $data[] = [
                'name' => str_random(10),
                'active' => true,
                'created_at' => gmdate('Y-m-d H:m:s')
            ];
        }

        DB::table('artists')->insert($data);*/
    }
}
