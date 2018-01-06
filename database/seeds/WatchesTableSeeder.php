<?php

use Illuminate\Database\Seeder;

class WatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('watches')->delete();
        DB::table('watches')->insert([
            ['id' => 1, 
            'user_id' => 1, 
            'episode_id' => 111,
            'rating' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ]);
    }
}
