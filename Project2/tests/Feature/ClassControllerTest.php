<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Classroom;
use App\Models\User;
use App\Http\Requests\ClassRequest;
use Illuminate\Support\Facades\Artisan;

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

    /** @test */
    public function an_admin_can_view_the_classroom_index_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.classrooms.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.classrooms.index');
        $response->assertSee('Quản lý lớp học');
        $response->assertViewHas('classrooms');
    }

    /** @test */
    public function an_admin_can_store_a_new_classroom()
    {
        $teacher = User::factory()->create(['role' => 1]);

        $data = [
            'name' => 'Test Classroom',
            'user_id' => $teacher->id,
            'status' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('classrooms.store'), $data);

        $response->assertRedirect(route('admin.classrooms.index'));
        $response->assertSessionHas('success', 'Lớp học đã được tạo thành công.');
        $this->assertDatabaseHas('classrooms', ['name' => 'Test Classroom', 'user_id' => $teacher->id, 'status' => 1]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing_a_classroom()
    {
        $response = $this->actingAs($this->admin)->post(route('classrooms.store'), []);

        $response->assertSessionHasErrors(['name', 'user_id', 'status']);
    }

    /** @test */
    public function an_admin_can_view_the_edit_classroom_page()
    {
        $teacher = User::factory()->create(['role' => 1]);
        $classroom = Classroom::factory()->create(['user_id' => $teacher->id]);

        $response = $this->actingAs($this->admin)->get(route('classrooms.edit', $classroom));

        $response->assertStatus(200);
        $response->assertViewIs('admin.classrooms.edit');
        $response->assertSee('Chỉnh sửa lớp học');
        $response->assertViewHas('classroom');
        $response->assertViewHas('teachers');
    }

    /** @test */
    public function an_admin_can_update_an_existing_classroom()
    {
        $teacher = User::factory()->create(['role' => 1]);
        $classroom = Classroom::factory()->create(['user_id' => $teacher->id]);

        $updatedData = [
            'name' => 'Updated Classroom Name',
            'user_id' => $teacher->id,
            'status' => 0,
        ];

        $response = $this->actingAs($this->admin)->put(route('classrooms.update', $classroom), $updatedData);

        $response->assertRedirect(route('admin.classrooms.index'));
        $response->assertSessionHas('success', 'Cập nhật lớp học thành công.');
        $this->assertDatabaseHas('classrooms', [
            'id' => $classroom->id,
            'name' => 'Updated Classroom Name',
            'user_id' => $teacher->id,
            'status' => 0,
        ]);
    }
}