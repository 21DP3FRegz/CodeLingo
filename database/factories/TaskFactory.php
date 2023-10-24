<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->sentence,
        ];
    }
}
