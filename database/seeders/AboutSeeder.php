<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'BEMS SDP Gedung 4 FT',
                'link' => 'https://iotlab-uns.com/sbms-ged-4/',
                'deskripsi' => 'Sebuah sistem manajemen energi (BEMS) untuk memantau dan mengontrol SDP pada Gedung 4 Fakutlas Teknik UNS'
            ]
        ];

        foreach ($data as $key => $value) {
            About::create($value);
        }
    }
}
