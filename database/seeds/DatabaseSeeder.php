<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
//        factory(\App\User::class, 100)->create();
        factory(\App\Category::class, 4)->create();
        factory(\App\Product::class, 500)->create();
    }
}
