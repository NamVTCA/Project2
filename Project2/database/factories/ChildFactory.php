<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName, // Sửa ở đây
            'birthDate' => Carbon::instance($this->faker->dateTimeBetween('-6 years', '-3 years')), 
            'gender' => $this->faker->randomElement([1, 2]), 
            'user_id' => User::factory(), 
            'status' => $this->faker->randomElement([0, 1]), 
        ];
    }
}