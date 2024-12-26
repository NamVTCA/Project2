<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Child;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChildrenImport;
use App\Exports\ChildrenExport;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChildControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('email', 'quangnguyen.21062005@gmail.com')->firstOrFail();
        $this->actingAs($this->admin);
    }

    /** @test */
    public function an_admin_can_view_the_children_index_page()
    {
        $response = $this->get(route('admin.children.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.children.index');
        $response->assertSee('Quản lý học sinh');
        $response->assertViewHas('children');
    }

    /** @test */
    public function an_admin_can_view_the_create_child_page()
    {
        $response = $this->get(route('admin.children.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.children.create');
        $response->assertSee('Tạo học sinh mới'); 
        $response->assertViewHas('users');
    }

    /** @test */
    public function an_admin_can_store_a_new_child()
    {
        $user = User::factory()->create(['role' => 2]);
        $childData = [
            'name' => 'Test Child',
            'birthDate' => now()->subYears(4)->format('Y-m-d'),
            'gender' => '1',
            'user_id' => $user->id,
            'status' => '1',
        ];

        $response = $this->post(route('admin.children.store'), $childData);

        $response->assertRedirect(route('admin.children.index'));
        $response->assertSessionHas('success', 'Tạo thông tin trẻ thành công.');
        $this->assertDatabaseHas('children', ['name' => 'Test Child', 'user_id' => $user->id]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing_a_child()
    {
        $response = $this->post(route('admin.children.store'), []);

        $response->assertSessionHasErrors(['name', 'gender', 'user_id']); // Sửa lại thành thế này
    }

    /** @test */
    public function an_admin_can_view_the_edit_child_page()
    {
        $child = Child::factory()->create();

        $response = $this->get(route('admin.children.edit', $child));

        $response->assertStatus(200);
        $response->assertViewIs('admin.children.edit');
        $response->assertSee('Chỉnh sửa thông tin học sinh');
        $response->assertViewHas('child');
        $response->assertViewHas('users');
    }

    /** @test */
    public function an_admin_can_update_an_existing_child()
    {
        $user = User::factory()->create(['role' => 2]);
        $child = Child::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'name' => 'Updated Child Name',
            'birthDate' => now()->subYears(3)->format('Y-m-d'),
            'gender' => '2',
            'user_id' => $user->id,
            'status' => '0',
        ];

        $response = $this->put(route('admin.children.update', $child), $updatedData);

        $response->assertRedirect(route('admin.children.index'));
        $response->assertSessionHas('success', 'Cập nhật thông tin trẻ thành công.');
        $this->assertDatabaseHas('children', [
            'id' => $child->id,
            'name' => 'Updated Child Name',
            'gender' => '2',
            'user_id' => $user->id,
            'status' => 0,
        ]);
    }

    /** @test */
    public function an_admin_can_import_children_from_excel()
    {
        Excel::fake();

        $file = UploadedFile::fake()->create('children.xlsx');

        $response = $this->post(route('admin.children.import'), ['file' => $file]);

        Excel::assertImported('children.xlsx', function (ChildrenImport $import) {
            return true;
        });

        $response->assertRedirect(route('admin.children.index'));
        $response->assertSessionHas('success', 'Thêm danh sách học sinh thành công!');
    }
    
    /** @test */
    public function it_shows_error_messages_when_importing_invalid_children_data()
    {
        $response = $this->post(route('admin.children.import'), []);
        $response->assertSessionHasErrors(['file']);
    }

    /** @test */
    public function an_admin_can_export_children_to_excel()
    {
        Excel::fake();

        $response = $this->get(route('admin.children.export'));

        $response->assertStatus(200);
        Excel::assertDownloaded('children.xlsx', function (ChildrenExport $export) {
            return true;
        });
    }
}