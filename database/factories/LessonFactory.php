<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'title' => $this->faker->sentence,
        ];
    }
}
