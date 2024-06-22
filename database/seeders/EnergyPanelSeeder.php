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
                'nama' => 'AC 1',
                'status' => '1'
            ],
            [
                'nama' => 'Instalasi 1',
                'status' => '0'
            ],
            [
                'nama' => 'AC 2',
                'status' => '0'
            ],
            [
                'nama' => 'Instalasi 2',
                'status' => '1'
            ]
        ];

        foreach ($user as $key => $value) {
            EnergyPanel::create($value);
        }
    }
}
