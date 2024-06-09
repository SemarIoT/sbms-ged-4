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
        $this->call([
            AboutSeeder::class,
            EnergyCostSeeder::class,
            EnergyPanelSeeder::class,
            EnergyKwhSeeder::class,
            EnergySeeder::class,
            UserSeeder::class,
        ]);
    }
}
