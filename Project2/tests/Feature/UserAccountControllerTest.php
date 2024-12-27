<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAccountControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();
        // Tạo một user admin
         /** @var \App\Models\User $admin */
        $this->admin = User::factory()->create(['role' => 0, 'email' => 'quangnguyen.21062005@gmail.com', 'password' => bcrypt('12345678')]);
        $this->actingAs($this->admin);
    }

    /** @test */
    public function an_admin_can_view_the_users_index_page()
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertSee('Quản lý tài khoản');
        $response->assertViewHas('accounts');
    }

    /** @test */
    public function an_admin_can_search_for_users()
    {
        $response = $this->get(route('admin.users.index', ['search' => 'Nguyen Van A'])); // Thay 'Nguyen Van A' bằng tên user bạn muốn tìm

        $response->assertStatus(200);
        $response->assertSee('Nguyen Van A'); // Thay 'Nguyen Van A' bằng tên user bạn muốn tìm
        // $response->assertDontSee('Tran Thi B'); // Bỏ comment nếu đã tạo user 'Tran Thi B'
    }

    /** @test */
    public function an_admin_can_filter_users_by_role()
    {
        $response = $this->get(route('admin.users.index', ['role' => 2])); // Thay 3 bằng role bạn muốn lọc
        $response->assertStatus(200);
        $usersInView = $response->viewData('accounts');

        // Kiểm tra số lượng và role của user (nếu cần)
        // $this->assertCount(2, $usersInView);
        // foreach ($usersInView as $user) {
        //     $this->assertEquals(3, $user->role);
        // }
    }

    /** @test */
    public function an_admin_can_store_a_new_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test' . fake()->unique()->numberBetween(1, 1000) . '@example.com', // Tạo email unique để tránh lỗi
            'password' => 'password',
            'id_number' => fake()->unique()->numerify('##########'), // Tạo id_number unique
            'address' => 'Test Address',
            'role' => 2,
            'status' => 1,
            'gender' => 'male',
            'phone' => '0123456789',
        ];

        $response = $this->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Tài khoản đã được tạo thành công!');
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    /** @test */
    public function it_validates_required_fields_when_storing_a_user()
    {
        $response = $this->post(route('admin.users.store'), []);
        $response->assertSessionHasErrors(['email', 'id_number', 'address', 'role', 'status', 'gender', 'phone']);
    }

    /** @test */
    public function an_admin_can_update_an_existing_user()
    {
        $user = User::factory()->create(['role' => 2]);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated' . fake()->unique()->numberBetween(1, 1000) . '@example.com', // Tạo email unique để tránh lỗi
            'password' => 'newpassword',
            'id_number' => fake()->unique()->numerify('##########'), // Tạo id_number unique
            'address' => 'Updated Address',
            'role' => 2,
            'status' => 0,
            'gender' => 'female',
            'phone' => '0987654321',
        ];

        $response = $this->put(route('admin.users.update', $user), $updatedData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Tài khoản đã được cập nhật!');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $updatedData['email'],
            'status' => 0
        ]);

        $updatedUser = User::find($user->id);
        $this->assertTrue(Hash::check('newpassword', $updatedUser->password));
    }

    /** @test */
    public function it_does_not_update_password_if_not_provided()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword'), 'role' => 2]);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated' . fake()->unique()->numberBetween(1, 1000) . '@example.com', // Tạo email unique để tránh lỗi
            'id_number' => fake()->unique()->numerify('##########'), // Tạo id_number unique
            'address' => 'Updated Address',
            'role' => 2,
            'status' => 1,
            'gender' => 'female',
            'phone' => '0987654321',
        ];

        $response = $this->put(route('admin.users.update', $user), $updatedData);
        $response->assertRedirect(route('admin.users.index'));

        $updatedUser = User::find($user->id);
        $this->assertTrue(Hash::check('oldpassword', $updatedUser->password));
    }

    /** @test */
    public function an_admin_can_delete_a_user()
    {
        $user = User::factory()->create(['role' => 2]);

        $response = $this->delete(route('admin.users.delete', $user));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Tài khoản đã được xóa!');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function an_admin_can_import_users_from_excel()
    {
        Excel::fake();

        $file = UploadedFile::fake()->create('users.xlsx');

        $response = $this->post(route('admin.users.import'), ['file' => $file]);

        Excel::assertImported('users.xlsx', function(UsersImport $import) {
            return true;
        });

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Thêm người dùng thành công!');
    }

    /** @test */
    public function an_admin_can_export_users_to_excel()
    {
        Excel::fake();

        $response = $this->get(route('admin.users.export'));

        $response->assertStatus(200);
        Excel::assertDownloaded('users.xlsx', function(UsersExport $export) {
            return true;
        });
    }
}