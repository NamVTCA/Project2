<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classroom;
use App\Models\User;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'user_id' => User::factory()->create(['role' => 1])->id, // Tạo user với role = 1 (giáo viên)
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}