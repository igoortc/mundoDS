<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 5)->create();
        DB::table('users')->delete();
        DB::table('users')->insert([
            ['id' => 1, 
            'name' => "Igs", 
            'email' => "igs@mail.com", 
            'password' => bcrypt('111111'), 
            'remember_token' => "FVGCu4RiZIwE3YOncHtQYWuvdHPfbdNg7fK3ZcBvsPBK4wx7Tn7wy4mAGqOx",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['id' => 2, 
            'name' => "Rach", 
            'email' => "rach@mail.com", 
            'password' => bcrypt('111111'), 
            'remember_token' => "FVGCu4RiZIwE3YOncHtQYWuvdHPfbdNg7fK3ZcBvsPBK4wx7Tn7wy4mAGqOx",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
