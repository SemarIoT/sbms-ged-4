<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IkeDummy;

class IkeDummySeeder extends Seeder
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
                'total_energy' => '264',
                'created_at' => '2023-01-01 23:50:00'
            ],
            [
                'total_energy' => '150',
                'created_at' => '2023-02-01 23:50:00'
            ],
            [
                'total_energy' => '400',
                'created_at' => '2023-03-01 23:50:00'
            ],
            [
                'total_energy' => '750',
                'created_at' => '2023-04-01 23:50:00'
            ],
            [
                'total_energy' => '529',
                'created_at' => '2023-05-01 23:50:00'
            ],
            [
                'total_energy' => '430',
                'created_at' => '2023-06-01 23:50:00'
            ],
            [
                'total_energy' => '330',
                'created_at' => '2023-07-01 23:50:00'
            ],
            [
                'total_energy' => '220',
                'created_at' => '2023-08-01 23:50:00'
            ],
            [
                'total_energy' => '264',
                'created_at' => '2023-09-01 23:50:00'
            ],
            [
                'total_energy' => '380',
                'created_at' => '2023-10-01 23:50:00'
            ],
            [
                'total_energy' => '645',
                'created_at' => '2023-11-01 23:50:00'
            ],
            [
                'total_energy' => '190',
                'created_at' => '2023-12-01 23:50:00'
            ],
            [
                'total_energy' => '50',
                'created_at' => '2024-01-01 23:50:00'
            ],

        ];

        foreach ($user as $key => $value) {
            IkeDummy::create($value);
        }
    }
}
