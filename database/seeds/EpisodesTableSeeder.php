<?php

use Illuminate\Database\Seeder;

class EpisodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('episodes')->delete();
        DB::table('episodes')->insert([
            ['id' => 111, 
            'name' => "Josh Just Happens to Live Here!", 
            'show_id' => 1,
            'season' => 1,
            'number' => 1,
            'synopsis' => "After a chance encounter with childhood sweetheart Josh Chan, Rebecca Bunch uproots her life and moves across the country, hoping to find happiness in his arms. As Rebecca settles in, new coworker Paula begins meddling in her business."],
            
            ['id' => 112, 
            'name' => "Josh's Girlfriend Is Really Cool!", 
            'show_id' => 1,
            'season' => 1,
            'number' => 2,
            'synopsis' => "Rebecca meets Josh's friends and goes to great lengths to bond with his girlfriend, Valencia."],

            ['id' => 121, 
            'name' => "Where Is Josh's Friend?", 
            'show_id' => 1,
            'season' => 2,
            'number' => 1,
            'synopsis' => "Rebecca thinks Josh is in love with her as she searches for Greg."],

            ['id' => 211, 
            'name' => "Pilot", 
            'show_id' => 2,
            'season' => 1,
            'number' => 1,
            'synopsis' => "Rory is accepted into the elite Chilton prep school. Bad news for Lorelai: she must make amends with her parents to borrow the money for Rory's tuition. The money is available--with strings attached."],
            ]);
    }
}
