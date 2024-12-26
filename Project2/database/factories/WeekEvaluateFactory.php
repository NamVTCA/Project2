<?php

namespace Database\Factories;

use App\Models\WeekEvaluate;
use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeekEvaluateFactory extends Factory
{
    protected $model = WeekEvaluate::class;

    public function definition(): array
    {
        return [
            'comment' => $this->faker->sentence(),
            'point' => $this->faker->numberBetween(0, 10),
            'date' => now()->format('Y-m-d'),
            'child_id' => Child::factory(),
        ];
    }
}
