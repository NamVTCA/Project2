<?php

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
use Illuminate\Support\Facades\Route;

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

Route::get('/timetable', function () {
    return view('timetable');
})->name('timetable');


Route::post('/timetable/save', [scheduleController::class, 'saveTimetable'])->name('timetable.save');
Route::get('/timetable/view', [scheduleController::class, 'viewTimetable'])->name('timetable.view');


Route::get('/feedbackList', function () {
    return view('feedbackList');
});

Route::get('/education', function () {
    return view('education');
})->name('education');


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
Route::prefix('admin')->group(function () {
    Route::middleware('auth.check')->group(function () {
        Route::middleware('role:0')->group(function () {
            Route::get('/schedule/show',[scheduleController::class,'index'])->name('schedule.show');
            Route::get('/dashboard/admin', [LoginController::class, 'admin'])->name('admin');
            Route::prefix('admin')->middleware('auth')->group(function () {
                Route::get('/users', [UserAccountController::class, 'index'])->name('admin.users.index');
                Route::get('/users/create', [UserAccountController::class, 'create'])->name('admin.users.create');
                Route::post('/users', [UserAccountController::class, 'store'])->name('admin.users.store');
                Route::get('/users/{user}/edit', [UserAccountController::class, 'edit'])->name('admin.users.edit');
                Route::put('/users/{user}', [UserAccountController::class, 'update'])->name('admin.users.update');
                Route::delete('/users/{user}', [UserAccountController::class, 'destroy'])->name('admin.users.delete');
                Route::get('/feedbackList', [FeedbackController::class, 'index'])->name('feedback.index');
                Route::delete('/feedbackList/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
            });
            Route::get('/children', [ChildController::class, 'index'])->name('admin.children.index');
            Route::get('/children/create', [ChildController::class, 'create'])->name('children.create');
            Route::post('/children', [ChildController::class, 'store'])->name('children.store');
            Route::get('/children/{child}/edit', [ChildController::class, 'edit'])->name('children.edit');
            Route::put('/children/{child}', [ChildController::class, 'update'])->name('children.update');
            Route::get('/classes', [ClassController::class, 'index'])->name('admin.classrooms.index');
            Route::get('/classes/create', [ClassController::class, 'create'])->name('classrooms.create');
            Route::post('/classes', [ClassController::class, 'store'])->name('classrooms.store');
            Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classrooms.show');
            Route::get('/classes/{classroom}/edit', [ClassController::class, 'edit'])->name('classrooms.edit');
            Route::put('/classes/{classroom}', [ClassController::class, 'update'])->name('classrooms.update');
            Route::get('/facilities', [FacilityManagementController::class, 'index'])->name('facility_management.index');
            Route::get('/facilities/create', [FacilityManagementController::class, 'create'])->name('facility_management.create');
            Route::post('/facilities', [FacilityManagementController::class, 'store'])->name('facility_management.store');
            Route::get('/facilities/{total}/edit', [FacilityManagementController::class, 'edit'])->name('facility_management.edit');
            Route::put('/facilities/{total}', [FacilityManagementController::class, 'update'])->name('facility_management.update');
            Route::delete('/facilities/{total}', [FacilityManagementController::class, 'destroy'])->name('facility_management.destroy');
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
        Route::post('/momo_payment',[paymentController::class,'momo_payment'])->name('momo_payment');
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


