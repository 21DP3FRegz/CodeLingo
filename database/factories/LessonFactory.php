<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;

class LessonFactory extends Factory
{
    protected int $order = 0;

    public function definition(): array
    {
        return [
            'order' => 0, // Default order
            'title' => fake()->text(20),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Lesson $lesson) {
            $topicId = $lesson->topic_id;
            $this->order++;

            // Update the order of the lesson
            $lesson->update(['order' => $this->order]);

            // Create three tasks for the lesson
            \App\Models\Task::factory()
                ->forLesson($lesson)
                ->count(3)
                ->create();
        });
    }
}
