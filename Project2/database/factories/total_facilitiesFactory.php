<?php

namespace Database\Factories;

use App\Models\total_facilities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\total_facilities>
 */
class Total_facilitiesFactory extends Factory
{
    protected $model = total_facilities::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(), // Tạo tên duy nhất
        ];
    }
}