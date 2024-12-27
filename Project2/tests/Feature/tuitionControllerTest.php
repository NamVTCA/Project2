<?php

namespace Tests\Feature;

use App\Http\Controllers\paymentController;
use App\Models\Child;
use App\Models\Classroom;
use App\Models\Tuition;
use App\Models\tuition_info;
use App\Models\User;
use Database\Factories\TuitionInfoFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class tuitionControllerTest extends TestCase
{

     /** @test */
    public function it_displays_selected_child_with_tuition()
    {
        // Tạo dữ liệu mẫu
        $child = Child::factory()->create();
        $user = User::factory()->create();
        $child->user()->associate($user)->save();

        $tuition = Tuition::factory()->create(['child_id' => $child->id]);

        // Gửi GET request với children_id
        $response = $this->get(route('tuition.index', ['children_id' => $child->id]));

        // Kiểm tra trạng thái HTTP
        $response->assertStatus(200);

        // Kiểm tra dữ liệu của học sinh được truyền vào
        $selectedChild = $response->viewData('selectedChild');
        $this->assertNotNull($selectedChild);
        $this->assertEquals($child->id, $selectedChild->id);
        $this->assertCount(1, $selectedChild->tuition);
    }
   

    /** @test */
  public function it_creates_tuition_()
    {
        // Tạo dữ liệu mẫu
        $classroom = Classroom::factory()->create();

        $data = [
            'classroom_id' => $classroom->id,
            'semester' => '2024 Spring',
            'tuition_details' => [
                ['name' => 'Math Fee', 'price' => 100],
                ['name' => 'Science Fee', 'price' => 200],
            ],
        ];

        // Gửi POST request đến route store
        $response = $this->post(route('tuition.store'), $data);

        // Kiểm tra kết quả redirect và thông báo
        $response->assertRedirect(route('tuition.create'));
        $response->assertSessionHas('success', 'Đã tạo học phí thành công');

}
 public function test_Momo_Payment_Success()
    {
        // Mock dữ liệu
        $tuition = Tuition::factory()->create(['semester' => '2023-2']);
        $tuitionInfo = tuition_info::factory()->count(3)->create([
            'tuition_id' => $tuition->id,
            'price' => 1000000,
        ]);
            /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $mockResponse = [
            'resultCode' => 0,
            'payUrl' => 'https://test-payment.momo.vn/test-url'
        ];

        // Mock hàm execPostRequest
        $this->mock(paymentController::class, function ($mock) use ($mockResponse) {
            $mock->shouldReceive('execPostRequest')->andReturn(json_encode($mockResponse));
        });

        // // Gửi yêu cầu
        // $response = $this->postJson(route('momo'), [
        //     'tuition_id' => $tuition->id,
        // ]);

        // $response->assertRedirect($mockResponse['payUrl']);
        $this->assertDatabaseHas('tuitions', ['id' => $tuition->id, 'status' => 1]);
    }
     public function test_Stripe_Payment_Success()
    {
        // Mock dữ liệu
        $tuition = Tuition::factory()->create(['semester' => '2023-2']);
        $tuitionInfo = tuition_info::factory()->count(3)->create([
            'tuition_id' => $tuition->id,
            'price' => 1000000,
        ]);
         /** @var \App\Models\User $user */

        $user = User::factory()->create();
        $this->actingAs($user);

        $mockSession = Mockery::mock('overload:Stripe\Checkout\Session');
        $mockSession->shouldReceive('create')->andReturn((object)[
            'id' => 'test_session_id',
            'url' => 'https://test-stripe.com/test-url'
        ]);

        // Gửi yêu cầu
        $response = $this->postJson(route('stripe_payment'), [
            'tuition_id' => $tuition->id,
        ]);

        $response->assertRedirect('https://test-stripe.com/test-url');
        $this->assertDatabaseHas('tuitions', ['id' => $tuition->id, 'status' => 1]);
    }
}
