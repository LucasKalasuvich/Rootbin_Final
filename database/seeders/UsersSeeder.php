<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'nik' => 'admin123',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ],
            [
                'name' => 'User',
                'nik' => 'user123',
                'password' => Hash::make('user123'),
                'role' => 'users'
            ],
            [
                'name' => 'Supervisor',
                'nik' => 'supervisor123',
                'password' => Hash::make('supervisor123'),
                'role' => 'supervisor'
            ],
            [
                'name' => 'Supervisor',
                'nik' => 'supervisor789',
                'password' => Hash::make('supervisor789'),
                'role' => 'supervisor'
            ],
        ];

        DB::table('users')->insert($users);
    }
}
