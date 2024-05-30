<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnergyPanel;

class EnergyPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'nama' => 'Lantai 1',
                'status' => '1'
            ],
            [
                'nama' => 'Lantai 2',
                'status' => '0'
            ],
            [
                'nama' => 'Lantai 3',
                'status' => '0'
            ],
            [
                'nama' => 'Master',
                'status' => '1'
            ],
        ];

        foreach ($user as $key => $value) {
            EnergyPanel::create($value);
        }
    }
}
