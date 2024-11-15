<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_successfully()
    {
        
        $user = User::factory()->create([
            'phone' => '0987654321',
            'password' => Hash::make('oldpassword'),
        ]);

        
        $response = $this->postJson('/reset-password', [
            'phone' => $user->phone,
            'otp' => '123456',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Mật khẩu đã được đặt lại thành công.']);

        
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_reset_password_with_invalid_otp()
    {
        $user = User::factory()->create(['phone' => '0987654321']);

        $response = $this->postJson('/reset-password', [
            'phone' => $user->phone,
            'otp' => 'wrong_otp',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(422)
                 ->assertJson(['message' => 'Mã xác nhận không chính xác.']);
    }
}
