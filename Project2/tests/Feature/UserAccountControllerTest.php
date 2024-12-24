<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Illuminate\Foundation\Testing\WithFaker;

class UserAccountControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test index method.
     *
     * @return void
     */
    public function test_index_displays_user_accounts()
    {
        // Tạo một user admin
            /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Tạo một số user giả lập với role khác 0
        $users = User::factory()->count(5)->create(['role' => 1]);

        // Thực hiện request GET đến route 'admin.users.index' với tư cách là admin
        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        // Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('accounts');

        // Kiểm tra xem các user có được hiển thị trong view không
        foreach ($users as $user) {
            $response->assertSee($user->name);
            $response->assertSee($user->email);
        }
    }
    public function test_index_filters_by_role()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        User::factory()->count(2)->create(['role' => 1]);
        User::factory()->count(2)->create(['role' => 2]);
        // Kiểm tra với role là 1
        $response = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 1]));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('accounts');

        //Kiểm tra view chỉ hiển thị user role 1
        foreach ($response->viewData('accounts') as $account) {
                $this->assertEquals(1, $account->role);
        }
        // Kiểm tra với role là 2
        $response = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 2]));
        foreach ($response->viewData('accounts') as $account) {
                $this->assertEquals(2, $account->role);
            }
    }
    public function test_index_searches_by_keyword()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com', 'id_number' => '123456789', 'phone' => '0987654321']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com', 'id_number' => '987654321', 'phone' => '0123456789']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    /**
     * Test store method.
     *
     * @return void
     */
    public function test_store_creates_new_user()
    {
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'id_number' => '123456789',
            'address' => $this->faker->address,
            'role' => 1,
            'status' => 1,
            'gender' => 'male',
            'phone' => $this->faker->numerify('0#########'),
        ];

        $response = $this->actingAs($admin)->post(route('admin.users.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    /**
     * Test update method.
     *
     * @return void
     */
    public function test_update_user_account()
    {
        // Tạo một user để test với role khác 0
        $user = User::factory()->create(['role' => 1]);

        // Dữ liệu cập nhật
        $updatedData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => null, // Không cập nhật password
            'id_number' => '9876543210', // Giá trị mới không trùng lặp
            'address' => $this->faker->address,
            'role' => 2,
                'status' => 0,
                'gender' => 'female',
                'phone' => $this->faker->numerify('0#########'),
        ];

        // Gửi request PUT với tư cách admin
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), $updatedData);

        // Kiểm tra chuyển hướng
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.index'));

        // Kiểm tra dữ liệu đã được cập nhật
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $updatedData['email'],
            'id_number' => $updatedData['id_number'],
        ]);

        // Kiểm tra các trường không thay đổi
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'password' => $user->password, // Password không thay đổi
        ]);
    }

    /**
     * Test destroy method.
     *
     * @return void
     */
    public function test_destroy_deletes_user_account()
    {
        // Tạo một user để test
        $user = User::factory()->create(['role'=>1]);

        // Gọi route delete để xóa user
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        $response = $this->actingAs($admin)->delete(route('admin.users.delete', $user));
        // Kiểm tra xem response có chuyển hướng về trang index không
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.index'));
        // Kiểm tra xem user đã bị xóa khỏi database chưa
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}