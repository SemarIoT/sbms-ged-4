<?php

namespace Database\Seeders;

use App\Models\EnergyKwh;
use Illuminate\Database\Seeder;

class EnergyKwhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnergyKwh::factory()->count(100)->create();
    }
}
