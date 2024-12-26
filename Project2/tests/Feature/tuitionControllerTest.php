<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\Tuition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

}
