<?php

namespace Database\Seeders;

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
         $this->call(PermissionTableSeeder::class);
         $this->call(CountrySeeder::class);
         $this->call(CitiesSeeder::class);
         $this->call(StatesSeeder::class);
        //$this->call([PermissionTableSeeder::class]);
    }
}
