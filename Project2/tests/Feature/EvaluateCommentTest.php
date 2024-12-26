<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\WeekEvaluate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluateCommentTest extends TestCase
{

       use RefreshDatabase;

    /** @test */
    public function it_creates_new_evaluation()
    {
        $child = Child::factory()->create();

        $response = $this->post('/evaluatecomment', [
            'comment' => 'Great work!',
            'point' => 8,
            'date' => now()->format('Y-m-d'),
            'child_id' => $child->id,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('weekevaluates', [
            'comment' => 'Great work!',
            'point' => 9,
            'child_id' => $child->id,
        ]);
    }
      /** @test */
    public function it_returns_student_details_and_evaluation()
    {
        $child = Child::factory()->create();
        $evaluation = WeekEvaluate::factory()->create([
            'child_id' => $child->id,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->get('/get-student-details?child_id=' . $child->id . '&date=' . now()->format('Y-m-d'));

        $response->assertJson([
            'success' => true,
            'student' => [
                'name' => $child->name,
                'birthDate' => $child->birthDate->format('Y-m-d'),
                'gender' => $child->gender,
                'className' => $child->classroom->pluck('name')->first(),
            ],
            'evaluation' => [
                'comment' => $evaluation->comment,
                'point' => $evaluation->point,
                'date' => $evaluation->date->format('Y-m-d'),
                'child_id' => $child->id,
            ],
        ]);
    }
}
