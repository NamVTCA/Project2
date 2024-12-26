<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Classroom;
use App\Models\User;
use App\Models\total_facilities;
use App\Models\dentail_facilities;
use App\Models\facilities;
use Illuminate\Http\Request;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\ClassRequest;

class ClassControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
         // Tạo một user admin
          $this->admin = User::factory()->create(['role' => 0]);
    }

    public function test_index_displays_classrooms()
    {
        // Tạo một số classrooms giả lập
        $classrooms = Classroom::factory()->count(3)->create();

        // Thực hiện request GET đến route 'admin.classrooms.index' với tư cách là admin
        $response = $this->actingAs($this->admin)->get(route('admin.classrooms.index'));
        // Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('admin.classrooms.index');
        $response->assertViewHas('classrooms');

        // Kiểm tra xem các classrooms có được hiển thị trong view không
        foreach ($response->viewData('classrooms') as $classroom) 
        {
            $response->assertSee($classroom->name);
        }
    }

    public function test_store_creates_new_classroom()
    {
        // Tạo một giáo viên cho lớp học
        /** @var \App\Models\User $teacher */
        $teacher = User::factory()->create(['role' => 1]);

        // Dữ liệu để tạo lớp học
        $data = [
            'name' => 'Classroom A',
            'user_id' => $teacher->id,
            'status' => 1,
        ];

        // Giả lập request
        $request = new ClassRequest($data);

        // Gọi phương thức store() trong ClassController
        $controller = new ClassController();
        $response = $controller->store($request);

        // Kiểm tra lớp học đã được tạo trong database chưa
        $this->assertDatabaseHas('classrooms', [
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'status' => $data['status'],
        ]);

        // Kiểm tra response
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.classrooms.index'));
        $response->assertSessionHas('success', 'Lớp học đã được tạo thành công!');
    }

    public function test_update_classroom()
    {
        // Tạo một user admin
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        // Tạo một giáo viên để test
        $teacher = User::factory()->create(['role' => 1]);
        // Tạo một lớp học để test
        $classroom = Classroom::factory()->create([
            'user_id' => $teacher->id,
            'status' => 1
        ]);

        // Dữ liệu cập nhật
        $updatedData = [
            'name' => 'Classroom Updated',
            'user_id' => $teacher->id, // Giữ nguyên giáo viên
            'status' => 0,
        ];

        // Thực hiện request PUT đến route 'classrooms.update'
        $response = $this->actingAs($admin)->put(route('classrooms.update', $classroom->id), $updatedData);

        // Kiểm tra chuyển hướng
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.classrooms.index'));

        // Kiểm tra xem thông tin lớp học đã được cập nhật chưa
        $this->assertDatabaseHas('classrooms', [
            'id' => $classroom->id,
            'name' => $updatedData['name'],
            'user_id' => $updatedData['user_id'],
            'status' => $updatedData['status'],
        ]);
   }
}