<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Построить дом',
                'description' => 'Согласно плану',
                'user_id' => User::all()->random()->id,
            ],
            [
                'name' => 'Привезти дачу',
                'description' => 'Как можно дешевле',
                'user_id' => User::all()->random()->id,
            ],
            [
                'name' => 'Построить гараж',
                'description' => 'В лучшей локации',
                'user_id' => User::all()->random()->id,
            ],
        ];
        foreach ($projects as $user) {
            DB::table('projects')->insert($user);
        }
    }
}
