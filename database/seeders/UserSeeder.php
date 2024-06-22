<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
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
                'username' => 'admin',
                'name' => 'Akun Admin',
                'email' => 'admin@example.com',
                'level' => 'Admin',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'izzan',
                'name' => 'Izzan',
                'email' => 'izzan@example.com',
                'level' => 'Admin',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'user',
                'name' => 'Akun User',
                'email' => 'user@example.com',
                'level' => 'User',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'developer',
                'name' => 'Akun Developer',
                'email' => 'developer@example.com',
                'level' => 'Developer',
                'password' => bcrypt('123456'),
            ],

        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
