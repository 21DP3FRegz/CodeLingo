<?php

namespace Database\Factories;

use App\Models\UserProgress;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProgressFactory extends Factory
{
    protected $model = UserProgress::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'task_id' => Task::factory(),
            'status' => $this->faker->randomElement(['completed', 'incomplete']),
        ];
    }
}