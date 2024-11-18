<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
// Route::get('/resetpassword', function () {
//     return view('resetpassword');
// });
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/index', function () {
    return view('index');
})->name('index');
Route::get('/forgotpassword', function () {
    return view('forgotpassword');
});
Route::get('/accountcreation', function () {
    return view('accountcreation');
});


Route::middleware(['auth'])->group(function () {
      Route::get('/schedule', [scheduleController::class, 'index'])->name('schedule');
});
Route::get('/showLogin',[loginController::class,'showLogin'])->name('showlogin');
Route::post('/login',[loginController::class,'login'])->name('login');
Route::get('/showfogot',[loginController::class,'showFogot'] )->name('showfogot');
Route::get('/otp',[loginController::class,'sendResetCode'])->name('otp');
Route::post('/resetpassword',[loginController::class,'resetPassword'])->name('resetpassword');

Route::resource('users', UserController::class);


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
