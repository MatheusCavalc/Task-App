<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\SubtaskStatusEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\Category::create([
            'name' => 'Job',
            'user_id' => 1,
        ]);

        \App\Models\Task::create([
            'user_id' => 1,
            'category_id' => 1,
            'name' => 'TODO List Project',
            'description' => 'sdnckadvlakjndvlakjsv sjdvksdnv laksjdv ka sd vbcansckjas',
            'status' => TaskStatusEnum::Waiting->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Frontend with Vue and Tailwind',
            'status' => SubtaskStatusEnum::Waiting->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Queues with Redis',
            'status' => SubtaskStatusEnum::Waiting->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Bun install',
            'status' => SubtaskStatusEnum::In_Progress->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Laravel Nova',
            'status' => SubtaskStatusEnum::In_Progress->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Sanctum API',
            'status' => SubtaskStatusEnum::Finished->value,
        ]);

        \App\Models\Subtask::create([
            'user_id' => 1,
            'task_id' => 1,
            'name' => 'Heroicon',
            'status' => SubtaskStatusEnum::Finished->value,
        ]);


    }
}
