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
            'name' => "Annalise", 
            'email' => "admin@mail.com", 
            'password' => bcrypt('123'),
            'photo' => 'http://res.cloudinary.com/ht0shxjqw/image/upload/v1515982910/anna_pwvhkn.jpg',
            'age' => 50,
            'city' => 'Philadelphia, PA, United States',
            'bio' => "I am who I am. If you don't like it, I don't care.",
            'admin' => 1,
            'remember_token' => "FVGCu4RiZIwE3YOncHtQYWuvdHPfbdNg7fK3ZcBvsPBK4wx7Tn7wy4mAGqOx",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['id' => 2, 
            'name' => "Igs", 
            'email' => "igs@mail.com", 
            'password' => bcrypt('123'),
            'photo' => 'http://res.cloudinary.com/ht0shxjqw/image/upload/v1500848811/daredevil_iuq5qj.jpg',
            'age' => 22,
            'city' => 'Chicago, IL, United States',
            'bio' => 'wild and fluorescent',
            'admin' => 0,
            'remember_token' => "FVGCu4RiZIwE3YOncHtQYWuvdHPfbdNg7fK3ZcBvsPBK4wx7Tn7wy4mAGqOx",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['id' => 3, 
            'name' => "Rach", 
            'email' => "rach@mail.com", 
            'password' => bcrypt('123'),
            'photo' => 'https://i.pinimg.com/736x/65/aa/95/65aa95066b59507cdc4476b1af586178.jpg',
            'age' => 22,
            'city' => 'New York, NY, United States',
            'bio' => 'the greatest star',
            'admin' => 0,
            'remember_token' => "FVGCu4RiZIwE3YOncHtQYWuvdHPfbdNg7fK3ZcBvsPBK4wx7Tn7wy4mAGqOx",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
