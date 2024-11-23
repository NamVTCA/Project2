<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\tuitionContoller;
use App\Http\Controllers\subjectController;

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
});

Route::get('/timetable', function () {
    return view('timetable');
});


Route::middleware(['auth'])->group(function () {
      Route::get('/schedule', [scheduleController::class, 'index'])->name('schedule');
});
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

Route::resource('users', UserController::class);

Route::get('/api/tuitions/{childId}', [paymentController::class, 'getTuitionsByChild']);
Route::get('/api/tuition-details/{tuitionId}', [paymentController::class, 'getTuitionDetails']);
Route::get('/momo',[paymentController::class,'index'])->name('momo');
Route::post('/momo_payment',[paymentController::class,'momo_payment'])->name('momo_payment');

Route::middleware('auth.check')->group(function () {
    Route::middleware('role:0')->group(function () {
        Route::get('/dashboard/admin', [LoginController::class, 'admin'])->name('admin');
    });

    Route::middleware('role:1')->group(function () {
        
        Route::get('/dashboard/teacher', [LoginController::class, 'teacher'])->name('teacher');
    });

    Route::middleware('role:2')->group(function () {
        Route::get('/dashboard/user', [LoginController::class, 'user'])->name('user');
    });
});

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard/admin', [LoginController::class, 'admin'])->name('admin');
//     Route::get('/dashboard/teacher', [LoginController::class, 'teacher'])->name('teacher');
//         Route::get('/dashboard/user', [loginController::class, 'user'])->name('user');
// });


Route::get('/schedule/details', [ScheduleController::class, 'getDetails']);
Route::delete('/schedule/delete', [ScheduleController::class, 'delete']);
Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
Route::get('/schedule/show',[scheduleController::class,'index'])->name('schedule.show');
Route::get('/logout',[loginController::class,'logout'])->name('logout');


Route::get('/subjects', [subjectController::class, 'index'])->name('subjects.index');
Route::post('/subjects', [subjectController::class, 'store'])->name('subjects.store');
Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');

Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
Route::post('/timetable/save', [TimetableController::class, 'save'])->name('timetable.save');
