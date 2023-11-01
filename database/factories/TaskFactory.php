<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->sentence,
            'answer' => fake()->word,
        ];
    }

    public function forLesson($lesson)
    {
        return $this->state([
            'lesson_id' => $lesson->id,
        ]);
    }
}
