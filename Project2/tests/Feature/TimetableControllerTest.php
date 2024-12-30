<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    

    /** @test */
    /** @test */
/** @test */
public function it_can_save_timetable()
{
    // Giả lập lưu trữ
    Storage::fake('local');

    // Mock dữ liệu gửi từ form
    $semester = 'semester1';
    $schedule = [
        'Monday' => 'Math',
        'Tuesday' => 'Science',
        'Wednesday' => 'History',
    ];

    // Gửi request để lưu thời khóa biểu
    $response = $this->post(route('timetable.save'), [
        'semester' => $semester,
        'schedule' => $schedule
    ]);

    // Kiểm tra phản hồi
    $response->assertRedirect(route('timetable', ['semester' => $semester]));
    $response->assertSessionHas('message', 'Lưu thời khóa biểu thành công');

    // Kiểm tra dữ liệu đã được lưu trong file JSON
    $timetables = json_decode(Storage::get('timetables.json'), true);
    $this->assertArrayHasKey($semester, $timetables);
    $this->assertEquals($schedule, $timetables[$semester]);
}


    /** @test */
    public function it_can_view_timetable()
    {
        // Mock dữ liệu trong file JSON
        $semester = 'semester1';
        $schedule = [
            'Monday' => 'Math',
            'Tuesday' => 'Science',
            'Wednesday' => 'History',
        ];
        Storage::put('timetables.json', json_encode([$semester => $schedule]));

        // Gửi request để xem thời khóa biểu
        $response = $this->get(route('timetable.view', ['semester' => $semester]));

        // Kiểm tra phản hồi
        $response->assertStatus(200);
        $response->assertViewIs('timebladeT');
        $response->assertViewHas('semesters');
        $response->assertViewHas('selectedSemester', $semester);
        $response->assertViewHas('schedule', $schedule);
    }

    /** @test */
   
    public function it_can_delete_a_semester()
    {
        // Mock dữ liệu trong file JSON
        $semester = 'semester1';
        $schedule = [
            'Monday' => 'Math',
            'Tuesday' => 'Science',
            'Wednesday' => 'History',
        ];
        Storage::put('timetables.json', json_encode([$semester => $schedule]));

        // Gửi request để xóa học kỳ
        $response = $this->delete(route('timetable.deleteSemester', $semester));

        // Kiểm tra phản hồi
        $response->assertRedirect(route('timetable.manage'));
        $response->assertSessionHas('success', "Đã xóa học kỳ '$semester'.");

        // Kiểm tra rằng học kỳ đã bị xóa khỏi file JSON
        $timetables = json_decode(Storage::get('timetables.json'), true);
        $this->assertArrayNotHasKey($semester, $timetables);
    }
}
