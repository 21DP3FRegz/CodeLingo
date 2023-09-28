<?php

namespace Database\Factories;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mentor>
 */
class MentorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = ['mobile development', 'game development', 'frotend development', 'backend development', 'data analyst', 'testing specialist'];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'course' => $courses[rand(0,5)],
            'description' => 'Experiansed specialist',
        ];
    }
}
