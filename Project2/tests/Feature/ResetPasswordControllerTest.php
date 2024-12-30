<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_change_password_form()
    {
        $user = User::factory()->create(); // Tạo người dùng giả lập
        $this->actingAs($user); // Đăng nhập người dùng

        $response = $this->get('/resetpassword'); // Đảm bảo đường dẫn chính xác
        $response->assertStatus(200);
        $response->assertViewIs('resetpassword');
    }

    public function test_change_password_successfully()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current_password')
        ]);

        $this->actingAs($user);

        $response = $this->post('/change-password', [
            'current_password' => 'current_password',
            'new_password' => 'new_password',
            'confirm_password' => 'new_password'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Đổi mật khẩu thành công');
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    public function test_change_password_with_incorrect_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current_password')
        ]);

        $this->actingAs($user);

        $response = $this->post('/change-password', [
            'current_password' => 'wrong_password',
            'new_password' => 'new_password',
            'confirm_password' => 'new_password'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('current_password');
    }

    public function test_change_password_with_validation_errors()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current_password')
        ]);

        $this->actingAs($user);

        $response = $this->post('/change-password', [
            'current_password' => '',
            'new_password' => 'short',
            'confirm_password' => 'different_password'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['current_password', 'new_password', 'confirm_password']);
    }

    public function test_change_password_when_user_not_authenticated()
    {
        // Không cần đăng nhập người dùng
        $response = $this->post('/change-password', [
            'current_password' => 'current_password',
            'new_password' => 'new_password',
            'confirm_password' => 'new_password'
        ]);

        // Kiểm tra xem có chuyển hướng về trang đăng nhập không
        $response->assertRedirect('/login'); // Thay '/login' bằng đường dẫn chính xác nếu khác

        // Kiểm tra xem có thông báo lỗi không (nếu bạn có logic hiển thị thông báo)
        // Nếu không có thông báo lỗi trong session, có thể bỏ qua dòng này
        // $response->assertSessionHas('error', 'Không tìm thấy người dùng');
    }
}
