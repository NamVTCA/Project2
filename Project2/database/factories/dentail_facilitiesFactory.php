<?php

namespace Database\Factories;

use App\Models\dentail_facilities;
use App\Models\total_facilities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\dentail_facilities>
 */
class dentail_facilitiesFactory extends Factory
{
    protected $model = dentail_facilities::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'total_id' => total_facilities::factory(), // Tạo mới total_facility nếu chưa có
        ];
    }
}