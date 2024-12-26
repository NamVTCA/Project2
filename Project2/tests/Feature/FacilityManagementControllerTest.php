<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\total_facilities;
use App\Models\dentail_facilities;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FacilityManagementControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        // Chạy migrate:fresh trước mỗi test case
        Artisan::call('migrate:fresh');
    }

    public function test_admin_can_access_facilities_index()
    {
        // Tạo một user admin
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Thực hiện request GET đến route 'facility_management.index' với tư cách là admin
        $response = $this->actingAs($admin)->get(route('facility_management.index'));

        // Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('admin.facilities.index');
        $response->assertViewHas('totals');
    }

    public function test_index_displays_facilities()
    {
        // Tạo một user admin
         /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Tạo một số total_facilities và dentail_facilities giả lập
        $totalFacilities = total_facilities::factory()->count(3)->create();
        foreach ($totalFacilities as $total) {
            dentail_facilities::factory()->count(2)->create(['total_id' => $total->id]);
        }

        // Thực hiện request GET đến route 'facility_management.index' với tư cách là admin
        $response = $this->actingAs($admin)->get(route('facility_management.index'));

        // Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('admin.facilities.index');
        $response->assertViewHas('totals');

        // Kiểm tra xem các total_facilities có được hiển thị trong view không
        foreach ($totalFacilities as $total) {
            $response->assertSee($total->name);
            foreach ($total->dentail as $dentail) {
                $response->assertSee($dentail->name);
            }
        }
    }

    public function test_store_creates_new_facility()
    {
        // Tạo một user admin
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Dữ liệu để tạo total_facility và dentail_facilities
        $data = [
            'name' => 'Test Facility',
            'dentail' => [
                ['name' => 'Detail 1', 'quantity' => 5],
                ['name' => 'Detail 2', 'quantity' => 10],
            ],
        ];

        // Thực hiện request POST đến route 'facility_management.store' với tư cách là admin
        $response = $this->actingAs($admin)->post(route('facility_management.store'), $data);

        // Kiểm tra response
        $response->assertStatus(302);
        $response->assertRedirect(route('facility_management.index'));

        // Kiểm tra xem total_facility đã được tạo trong database chưa
        $this->assertDatabaseHas('total_facilities', [
            'name' => $data['name'],
        ]);

        // Kiểm tra xem các dentail_facilities đã được tạo trong database chưa
        $total = total_facilities::where('name', $data['name'])->first();
        foreach ($data['dentail'] as $dentail) {
            $this->assertDatabaseHas('dentail_facilities', [
                'total_id' => $total->id,
                'name' => $dentail['name'],
                'quantity' => $dentail['quantity'],
            ]);
        }
    }

    public function test_update_facility()
    {
        // Tạo một user admin
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 0]);

        // Tạo một total_facility và dentail_facilities để test
        $total = total_facilities::factory()->create();
        $dentail = dentail_facilities::factory()->create(['total_id' => $total->id]);

        // Dữ liệu cập nhật
        $updatedData = [
            'name' => 'Updated Facility Name',
            'dentail' => [
                [
                    'id' => $dentail->id,
                    'name' => 'Updated Detail Name',
                    'quantity' => 15,
                ],
            ],
        ];

        // Thực hiện request PUT đến route 'facility_management.update' với tư cách là admin
        $response = $this->actingAs($admin)->put(route('facility_management.update', $total->id), $updatedData);

        // Kiểm tra response
        $response->assertStatus(302);
        $response->assertRedirect(route('facility_management.index'));

        // Kiểm tra xem total_facility đã được cập nhật trong database chưa
        $this->assertDatabaseHas('total_facilities', [
            'id' => $total->id,
            'name' => $updatedData['name'],
        ]);

        // Kiểm tra xem dentail_facility đã được cập nhật trong database chưa
        $this->assertDatabaseHas('dentail_facilities', [
            'id' => $dentail->id,
            'name' => $updatedData['dentail'][0]['name'],
            'quantity' => $updatedData['dentail'][0]['quantity'],
        ]);
    }
}