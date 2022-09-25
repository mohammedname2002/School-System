<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database;
use NationalitiesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
$this->call(BloodTableSeeder::class) ;
        $this->call(NationalitieTableSeeder::class) ;
        $this->call(ReligionTableSeeder::class) ;
        $this->call(SpecializationTableSeeder::class) ;
        $this->call(GenderTableSeeder::class) ;

    }
}
