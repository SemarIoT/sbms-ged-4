<?php

namespace Database\Seeders;

use App\Models\Energy;
use Illuminate\Database\Seeder;

class EnergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Energy::factory()->count(100)->create();
    }
}
