<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Купить материалы',
                'description' => 'Дешевле',
                'user_id' => User::all()->random()->id,
                'project_id' => Project::all()->random()->id,
                'assignee_id' => User::all()->random()->id,
                'timer_started_at' => '2023-01-01 00:00:00',
                'timer_stopped_at' => null,
            ],
            [
                'name' => 'Составить план',
                'description' => 'С учетом всех особенностей',
                'user_id' => User::all()->random()->id,
                'project_id' => Project::all()->random()->id,
                'assignee_id' => User::all()->random()->id,
                'timer_started_at' => '2023-01-01 00:00:00',
                'timer_stopped_at' => '2023-01-01 00:14:05',
            ],
            [
                'name' => 'Провести электричество',
                'description' => '',
                'user_id' => User::all()->random()->id,
                'project_id' => Project::all()->random()->id,
                'assignee_id' => User::all()->random()->id,
                'timer_started_at' => null,
                'timer_stopped_at' => null,
            ],
        ];
        foreach ($tasks as $task) {
            DB::table('tasks')->insert($task);
        }
    }
}
