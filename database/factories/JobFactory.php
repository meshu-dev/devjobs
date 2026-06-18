<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'job_id' => fake()->randomNumber(5, true),
            'title' => fake()->jobTitle(),
            'description' => fake()->randomHtml(),
            'employer' => fake()->company(),
            'location' => fake()->country(),
            'min_salary' => 20000,
            'max_salary' => 40000,
            'url' => fake()->url(),
            'favourited' => false,
            'params' => [],
            'posted_at' => now(),
        ];
    }
}
