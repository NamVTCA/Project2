<?php

use App\Http\Controllers\cameraController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\evaluateController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\tuitionContoller;
use App\Http\Controllers\subjectController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\FacilityManagementController;
use App\Http\Controllers\ChildClassController;
use App\Http\Controllers\messageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::delete('/camera/{id}', [CameraController::class, 'destroy'])->name('camera.delete');

Route::get('/cameras', [cameraController::class, 'index'])->name('cameras.index');
Route::get('/camerasuser', [cameraController::class, 'indexUser'])->name('cameras.indexUser');
Route::get('/cameras/create', [CameraController::class, 'create'])->name('cameras.create'); 
Route::post('/cameras/store', [CameraController::class, 'store'])->name('cameras.store'); 
Route::get('/timetable/export-pdf', [scheduleController::class, 'exportPDF'])->name('timetable.exportPDF');

Route::post('/get-new-messages', [messageController::class, 'getNewMessages'])->name('chat.getNewMessages');

Route::middleware('auth')->group(function () {
    Route::get('/teacher/chat', [messageController::class, 'teacherChat'])->name('teacher.chat');
    Route::get('/parent/chat', [messageController::class, 'parentChat'])->name('parent.chat');
    Route::post('/send-message', [messageController::class, 'sendMessage'])->name('send.message');
    Route::get('/chat-history/{receiverId}', [messageController::class, 'chatHistory'])->name('chat.history');
});

Route::get('/', function () {
    return view('index');
});
Route::get('/resetpassword', function () {
    return view('resetpassword');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/accountcreation', function () {
    return view('accountcreation');
})->name('accountcreation');

Route::get('/cam', function () {
    return view('camdemo.cam');
})->name('cam');

Route::get('/cam/create', function () {
    return view('camdemo.create');
})->name('camcreate');

Route::get('/link-to-goals', function () {
    return view('link-to-goals');
})->name('link-to-goals');


Route::get('/timetable', function () {
    return view('timetable');
})->name('timetable');

Route::get('/rules', function () {
    return view('rules');
})->name('rules');


Route::post('/timetable/save', [scheduleController::class, 'saveTimetable'])->name('timetable.save');
Route::get('/timetable/view', [scheduleController::class, 'viewTimetable'])->name('timetable.view');


Route::get('/feedbackList', function () {
    return view('feedbackList');
});

Route::get('/education', function () {
    return view('education');
})->name('education');

Route::get('/event', function () {
    return view('event');
})->name('event');

Route::get('/teachers', [UserAccountController::class, 'teachers'])->name('teachers');

Route::get('/profile', function(){
    return view('admin.users.profile');
});
Route::get('/schedule/test',[scheduleController::class,'test'])->name('schedule.user');

// Route::get('/tuitionmanagement', function () {
//     return view('tuitionmanagement');
// })->name('tuitionmanagement');

Route::get('/childget/{id}',[evaluateController::class,'index'] );

Route::get('/timetable/manage', [scheduleController::class, 'manageSemesters'])->name('timetable.manage');
Route::delete('/timetable/manage/{semester}', [scheduleController::class, 'deleteSemester'])->name('timetable.deleteSemester');
Route::get('/monthly-statistics', [loginController::class, 'getMonthlyStatistics']);


Route::get('/tuitionmanagement',[tuitionContoller::class,'index'] )->name('tuitionmanagement');

Route::get('/feedback', function () {
    return view('feedback');
})->name('feedback');
Route::post('/feedback',[FeedbackController::class,'feedback'])->name('feedbackSend');

Route::middleware(['auth'])->group(function () {
      Route::get('/schedule', [scheduleController::class, 'index'])->name('schedule');
});
Route::get('/api/schedule/details', [ScheduleController::class, 'getScheduleDetails']);
Route::delete('/schedule/delete', [ScheduleController::class, 'deleteSchedule']);
Route::get('/api/student/details', [loginController::class, 'getStudentDetails']);
Route::get('/schedule/user',[scheduleController::class,'user'])->name('schedule.user');
Route::get('/tuition', [tuitionContoller::class, 'index'])->name('tuition.index');
Route::get('/tuition/create', [tuitionContoller::class, 'create'])->name('tuition.create');
Route::post('/tuition/store', [tuitionContoller::class, 'store'])->name('tuition.store');
Route::get('/showLogin',[loginController::class,'showLogin'])->name('showlogin');
Route::post('/login',[loginController::class,'login'])->name('login');
Route::get('/showfogot',[loginController::class,'showFogot'] )->name('showfogot');
Route::get('/otp',[loginController::class,'sendResetCode'])->name('otp');
Route::post('/forgotpassword',[loginController::class,'resetPassword'])->name('forgotpassword');
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ResetPasswordController::class, 'showChangepasswordForm'])->name('reset.password.form');
    Route::post('/change-password', [ResetPasswordController::class, 'changePassword'])->name('reset.password');
});
Route::prefix('admin')->group(function () 
{
    Route::middleware('auth.check')->group(function () 
    {
        Route::middleware('role:0')->group(function () 
        {
            Route::get('/dashboard/admin', [LoginController::class, 'admin'])->name('admin');
            Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('admin.dashboard');

            Route::get('/schedule/show',[scheduleController::class,'index'])->name('schedule.show');
            Route::prefix('admin')->middleware('auth')->group(function () 
            {
                // Các route cho user account
                Route::get('/users', [UserAccountController::class, 'index'])->name('admin.users.index');
                Route::get('/users/create', [UserAccountController::class, 'create'])->name('admin.users.create');
                Route::post('/users', [UserAccountController::class, 'store'])->name('admin.users.store');
                Route::get('/users/{user}/edit', [UserAccountController::class, 'edit'])->name('admin.users.edit');
                Route::put('/users/{user}', [UserAccountController::class, 'update'])->name('admin.users.update');
                Route::post('/users/import', [UserAccountController::class, 'import'])->name('admin.users.import');
                Route::get('/users/export', [UserAccountController::class, 'export'])->name('admin.users.export');
                Route::delete('/users/{user}', [UserAccountController::class, 'destroy'])->name('admin.users.delete');
                Route::get('/feedbackList', [FeedbackController::class, 'index'])->name('feedback.index');
                Route::delete('/feedbackList/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
                // Các route cho children
                Route::get('/children', [ChildController::class, 'index'])->name('admin.children.index');
                Route::get('/children/create', [ChildController::class, 'create'])->name('admin.children.create');
                Route::post('/children', [ChildController::class, 'store'])->name('admin.children.store');
                Route::get('/children/{child}/edit', [ChildController::class, 'edit'])->name('admin.children.edit');
                Route::put('/children/{child}', [ChildController::class, 'update'])->name('admin.children.update');
                Route::post('/children/import', [ChildController::class, 'import'])->name('admin.children.import');
                Route::get('/children/export', [ChildController::class, 'export'])->name('admin.children.export');

                // Các route cho classes
                Route::get('/classes', [ClassController::class, 'index'])->name('admin.classrooms.index');
                Route::get('/classes/create', [ClassController::class, 'create'])->name('classrooms.create');
                Route::post('/classes', [ClassController::class, 'store'])->name('classrooms.store');
                Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classrooms.show');
                Route::get('/classes/{classroom}/edit', [ClassController::class, 'edit'])->name('classrooms.edit');
                Route::put('/classes/{classroom}', [ClassController::class, 'update'])->name('classrooms.update');

                // Các route cho facilities
                Route::get('/facilities', [FacilityManagementController::class, 'index'])->name('facility_management.index');
                Route::get('/facilities/create', [FacilityManagementController::class, 'create'])->name('facility_management.create');
                Route::post('/facilities', [FacilityManagementController::class, 'store'])->name('facility_management.store');
                Route::get('/facilities/{total}/edit', [FacilityManagementController::class, 'edit'])->name('facility_management.edit');
                Route::put('/facilities/{total}', [FacilityManagementController::class, 'update'])->name('facility_management.update');
                Route::delete('/facilities/{total}', [FacilityManagementController::class, 'destroy'])->name('facility_management.destroy');
            });
        });
    });
});
Route::get('/api/get-dentails/{total_id}', [FacilityManagementController::class, 'getDentailFacilities']);


    Route::middleware('role:1')->group(function () {
        Route::get('/teacher',[loginController::class,'showDashboard'])->name('showDashboard');
        Route::post('/evaluate',[evaluateController::class,'evaluatecomment'])->name('evaluate');
        
        Route::get('/evaluate',[evaluateController::class,'show']);
        Route::get('/dashboard/teacher', [LoginController::class, 'teacher'])->name('teacher');
    });
        Route::middleware('role:2')->group(function () {
        Route::get('/dashboard/user', [LoginController::class, 'user'])->name('user');

    });
        Route::get('/tuitions/{childId}', [paymentController::class, 'getTuitionsByChild']);
        Route::get('/tuition-details/{tuitionId}', [paymentController::class, 'getTuitionDetails']);
        Route::get('/momo',[paymentController::class,'index'])->name('momo');
        Route::post('/momo_payment', [PaymentController::class, 'momo_payment'])->name('momo_payment');
Route::post('/stripe_payment', [PaymentController::class, 'stripe_payment'])->name('stripe_payment');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process_payment');
Route::get('/momo/callback/{tuition_id}', [PaymentController::class, 'handleMoMoPaymentCallback'])->name('momo.callback');





// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard/admin', [LoginController::class, 'admin'])->name('admin');
//     Route::get('/dashboard/teacher', [LoginController::class, 'teacher'])->name('teacher');
//         Route::get('/dashboard/user', [loginController::class, 'user'])->name('user');
// });


Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
Route::post('/logout',[loginController::class,'logout'])->name('logout');
Route::get('/subjects', [subjectController::class, 'index'])->name('subjects.index');
Route::post('/subjects', [subjectController::class, 'store'])->name('subjects.store');
Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
// Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
// Route::post('/timetable/save', [TimetableController::class, 'save'])->name('timetable.save');




// Route::get('/accounts', [AccountController::class, 'index'])->name('account.index');
// Route::get('/accounts/create', [AccountController::class, 'create'])->name('account.create');
// Route::post('/accounts/store', [AccountController::class, 'store'])->name('account.store');
// Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('account.edit');
// Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('account.update');
// Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('account.delete');


Route::prefix('childclass')->group(function () {
    Route::get('create', [ChildClassController::class, 'create'])->name('childclass.create');
    Route::post('store', [ChildClassController::class, 'store'])->name('childclass.store');
    Route::get('index', [ChildClassController::class, 'index'])->name('childclass.index');
    Route::get('{child_id}/{classroom_id}/edit', [ChildClassController::class, 'edit'])->name('childclass.edit');
    Route::post('{child_id}/{classroom_id}/update', [ChildClassController::class, 'update'])->name('childclass.update');
});




Route::delete('/admin/users/delete-all', [UserAccountController::class, 'deleteAll'])->name('admin.users.deleteAll');
