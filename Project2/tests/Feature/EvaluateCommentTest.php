<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\WeekEvaluate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class EvaluateCommentTest extends TestCase
{

      

    /** @test */
    public function it_creates_new_evaluation()
    {
        $child = Child::factory()->create();

        $response = $this->post('/evaluatecomment', [
            'comment' => 'Great work!',
            'point' => 8,
            'date' => Carbon::now()->format('Y-m-d'), 
            'child_id' => $child->id,
        ]);

        $response->assertSessionHasNoErrors();
       
    }
      /** @test */
   public function it_returns_student_details_and_evaluation()
{
    $child = Child::factory()->create();
    
    // Create the evaluation with Carbon instance for 'date'
    $evaluation = WeekEvaluate::factory()->create([
        'child_id' => $child->id,
        'date' => Carbon::now(), // Using Carbon instance directly
    ]);

    $response = $this->get('/api/student/details?child_id=' . $child->id . '&date=' . now()->format('Y-m-d'));


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
            'date' => $evaluation->date->format('Y-m-d'), // This will now work without errors
            'child_id' => $child->id,
        ],
    ]);
}

}
