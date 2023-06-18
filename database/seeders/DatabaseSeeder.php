<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Status::factory()->create([
            'text' => 'Онлайн',
            'color' => "#00e600"
        ]);
        Status::factory()->create([
            'text' => 'Офлайн',
            'color'=> '#ff0000'
        ]);

        User::factory()->create([
            'name' => 'Пользователь 1',
            'password' => '$2y$10$hBUPc5vGR887xkIWYLOO3ut.kt0QTd2mXO/VKMvlavPWX16ZYFaOe'
        ]);

        User::factory()->create([
            'name' => 'Пользователь 2',
            'password' => '$2y$10$hBUPc5vGR887xkIWYLOO3ut.kt0QTd2mXO/VKMvlavPWX16ZYFaOe'
        ]);
    }
}
