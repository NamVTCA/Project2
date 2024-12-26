<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Tài khoản có sẵn
        $email = 'hongtruongbvn2k5@gmail.com';
        $password = 'newpassword123';
        
        // Đảm bảo tài khoản tồn tại trong cơ sở dữ liệu
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user, "User không tồn tại trong cơ sở dữ liệu.");
        $this->assertTrue(Hash::check($password, $user->password), "Mật khẩu không khớp.");

        // Gửi yêu cầu đăng nhập
        $response = $this->post(route('login'), [
            'email' => $email,
            'password' => $password,
        ]);

        // Kiểm tra kết quả
        $response->assertRedirect(); // Đảm bảo chuyển hướng sau khi đăng nhập
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        // Tài khoản có sẵn
        $email = 'hongtruongbvn2k5@gmail.com';
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user, "User không tồn tại trong cơ sở dữ liệu.");

        // Đăng nhập user
        $this->actingAs($user);

        // Gửi yêu cầu đăng xuất
        $response = $this->post(route('logout'));

        // Kiểm tra kết quả
        $response->assertRedirect(route('showlogin')); // Chuyển hướng về trang đăng nhập
        $response->assertSessionHas('message', 'Bạn đã đăng xuất thành công.'); // Kiểm tra thông báo
        $this->assertGuest(); // Đảm bảo user không còn đăng nhập
    }

    /** @test */
    public function user_can_forgot_password_with_valid_otp()
    {
        // Tài khoản có sẵn
        $email = 'hongtruongbvn2k5@gmail.com';
        $newPassword = 'newpassword123';
        

        // Đảm bảo tài khoản tồn tại trong cơ sở dữ liệu
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user, "User không tồn tại trong cơ sở dữ liệu.");

        // Thiết lập session cho OTP
        Session::put('reset_code', '123456');
        Session::put('email', $email);

        // Gửi yêu cầu đặt lại mật khẩu
        $response = $this->post(route('forgotpassword'), [
            'phone' => '0123456789',
            'otp' => '123456',
            'email' => $email,
            'new_password' => $newPassword,
            'confirm_password' => $newPassword,
        ]);

        // Kiểm tra kết quả
        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password), "Mật khẩu mới không chính xác."); // Kiểm tra mật khẩu mới
    }
    /** @test */
 public function user_reset_password()
{
    $email = 'hongtruongbvn2k5@gmail.com';
    $currentPass = 'newpassword123'; // Giả định đây là mật khẩu hiện tại
    $newPass = 'newpassword123'; // Mật khẩu mới
    $confirmPass = 'newpassword123';

    $user = User::where('email', $email)->first();
    $this->assertNotNull($user, "User không tồn tại trong cơ sở dữ liệu.");

    $response = $this->post(route('login'), [
        'phone' => '0123456789',
        'email' => $email,
        'password' => $currentPass,
    ]);
    $response = $this->post(route('reset.password'), [
        'current_password' => $currentPass,
        'new_password' => $newPass,
        'confirm_password' => $confirmPass,
    ]);

    // Kiểm tra mật khẩu đã được đổi
    $this->assertTrue(Hash::check($newPass, $user->fresh()->password), "Mật khẩu mới không chính xác.");
}

}
