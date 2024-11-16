<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/resetpassword', function () {
//     return view('resetpassword');
// });
Route::get('/login', function () {
    return view('login');
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/fogotpassword', function () {
    return view('fogotpassword');
});
Route::get('/accountcreation', function () {
    return view('accountcreation');
});
Route::get('/showReset',[loginController::class,'showReset'] )->name('showReset');
Route::get('/otp',[loginController::class,'sendResetCode'])->name('otp');
Route::get('/resetPassword',[loginController::class,'resetPassword'])->name('resetPassword');



