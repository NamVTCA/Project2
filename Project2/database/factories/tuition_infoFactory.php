<?php

namespace Database\Factories;

use App\Models\tuition;
use App\Models\tuition_info;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\tuition_info>
 */
class tuition_infoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = tuition_info::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100000, 2000000),
            'tuition_id' => tuition::factory(), // Tạo tuition_id từ factory của Tuition
        ];
    }
}
