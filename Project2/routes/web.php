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


Route::get('/showfogot',[loginController::class,'showFogot'] )->name('showfogot');
Route::get('/otp',[loginController::class,'sendResetCode'])->name('otp');
Route::get('/forgotpassword',[loginController::class,'resetPassword'])->name('forgotpassword');



