<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Child;
use App\Models\User;

class ChildControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_access_children_index()
    {
        // Tạo một user với role là admin (role = 0)
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Thực hiện request GET đến route 'admin.children.index' với tư cách là admin
        $response = $this->actingAs($admin)->get(route('admin.children.index'));

        // Kiểm tra response
        $response->assertStatus(200); // Đảm bảo rằng trang được truy cập thành công
        $response->assertViewIs('admin.children.index'); // Đảm bảo rằng view trả về là 'admin.children.index'
        $response->assertViewHas('children'); // Kiểm tra xem view có biến 'children' hay không
    }

    public function test_index_displays_children()
    {
        // Tạo một user với role là admin
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
        $parent = User::factory()->create(['role' => 2]);
        // Tạo một số child giả lập
        $children = Child::factory()->count(5)->create(['user_id'=>$parent->id]);

        // Thực hiện request GET đến route 'admin.children.index' với tư cách là admin
        $response = $this->actingAs($admin)->get(route('admin.children.index'));

        // Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('admin.children.index');
        $response->assertViewHas('children');

        // Kiểm tra xem các child có được hiển thị trong view không
        foreach ($children as $child) {
            $response->assertSee($child->name);
            $response->assertSee($child->birthDate->format('d/m/Y'));
        }
    }

     public function test_store_creates_new_child()
     {
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
         $parent = User::factory()->create(['role' => 2]);
         $childData = [
             'name' => $this->faker->name,
             'birthDate' => now()->subYears(4)->format('Y-m-d'),
             'gender' => '1',
            'user_id' => $parent->id,
             'status' => '1',
       ];

         $response = $this->actingAs($admin)->post(route('children.store'), $childData);

         $response->assertStatus(302);
         $response->assertRedirect(route('admin.children.index'));

          $this->assertDatabaseHas('children', [
             'name' => $childData['name'],
            'user_id' => $childData['user_id'],
          ]);
      }

      public function test_update_child()
     {
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);
         $parent = User::factory()->create(['role' => 2]);
       // Tạo một child giả lập
        $child = Child::factory()->create(['user_id' => $parent->id]);

        // Dữ liệu cập nhật
         $updatedData = [
            'name' => $this->faker->name,
            'birthDate' => now()->subYears(3)->format('Y-m-d'),
           'gender' => '2',
           'user_id' => $parent->id,
            'status' => '0',
        ];

         // Gửi request PUT đến route 'children.update'
        $response = $this->actingAs($admin)->put(route('children.update', $child->id), $updatedData);

          // Kiểm tra response
         $response->assertStatus(302);
        $response->assertRedirect(route('admin.children.index'));

        // Kiểm tra xem child đã được cập nhật trong database chưa
         $this->assertDatabaseHas('children', [
           'id' => $child->id,
            'name' => $updatedData['name'],
            'user_id' => $updatedData['user_id'],
            'gender' => $updatedData['gender'],
           'status' => $updatedData['status'],
         ]);
     }

}