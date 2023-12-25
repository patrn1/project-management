<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'manager',
                'email' => 'manager@mail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'tester',
                'email' => 'tester@mail.com',
                'password' => Hash::make('password'),
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
