<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_feedback_list()
    {
        Feedback::factory()->count(5)->create();

        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.feedbackList');
        $response->assertViewHas('feedbacks');
    }

    /** @test */
    public function it_can_delete_a_feedback()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->delete(route('feedback.destroy', $feedback->id));

        $response->assertRedirect(route('feedback.index'));
        $this->assertDatabaseMissing('feedbacks', ['id' => $feedback->id]);
    }

    /** @test */
    public function it_can_create_feedback()
    {
        $user = User::factory()->create(['role' => 0]);

        $response = $this->post(route('feedback.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'This is a test feedback.',
        ]);

        $response->assertRedirect(route('feedback'));
        $response->assertSessionHas('success', 'Cảm ơn bạn đã gửi phản hồi');

        $this->assertDatabaseHas('feedbacks', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'content' => 'This is a test feedback.',
            'user_id' => $user->id,
        ]);
    }
}
