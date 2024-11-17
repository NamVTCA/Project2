<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
Route::get('/fogotpassword', function () {
    return view('fogotpassword');
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
Route::post('/forgotpassword',[loginController::class,'resetPassword'])->name('forgotpassword');

Route::resource('users', UserController::class);