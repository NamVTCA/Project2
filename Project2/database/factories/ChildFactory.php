<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChildFactory extends Factory
{
    protected $model = Child::class;

    public function definition(): array
    {
        $birthDate = Carbon::now()->subMonths(rand(3, 72));

        return [
            'name' => $this->faker->name,
            'birthDate' => $birthDate, // Sử dụng biến $birthDate
            'gender' => $this->faker->randomElement([1, 2]),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}