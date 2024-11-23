<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\tuitionContoller;
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


Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('reset.password');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password.update');


Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/children', [ChildController::class, 'index'])->name('admin.children.index');
    Route::get('/children/create', [ChildController::class, 'create'])->name('children.create');
    Route::post('/children', [ChildController::class, 'store'])->name('children.store');
    Route::get('/children/{child}', [ChildController::class, 'show'])->name('children.show');
    Route::get('/children/{child}/edit', [ChildController::class, 'edit'])->name('children.edit');
    Route::put('/children/{child}', [ChildController::class, 'update'])->name('children.update');
});

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
Route::get('/logout',[loginController::class,'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');

//     Route::get('/teacher/dashboard', function () {
//         return view('teacher.dashboard');
//     })->name('teacher.dashboard');

//     Route::get('/parent/dashboard', function () {
//         return view('parent.dashboard');
//     })->name('parent.dashboard');
// });
