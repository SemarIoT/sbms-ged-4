<?php

namespace Database\Seeders;

use App\Models\EnergyOutlet;
use App\Models\FireAlarm;
use App\Models\LightDimmer;
use Illuminate\Database\Seeder;
use Database\Seeders\EnergyPanelMasterSeeder;

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
            EnergySeeder::class,
            UserSeeder::class,
        ]);
    }
}
