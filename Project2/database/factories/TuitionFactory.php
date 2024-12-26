<?php

namespace Database\Factories;

use App\Models\child;
use App\Models\tuition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tuition>
 */
class TuitionFactory extends Factory
{
    protected $model = tuition::class;

    public function definition()
    {
        return [
            'semester' => $this->faker->word(),
            'child_id' => child::factory(),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
