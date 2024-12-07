<?php
use App\Http\Controllers\FacilityManagementController;
use Illuminate\Support\Facades\Route;

Route::post('/dentail_facilities/increment', [FacilityManagementController::class, 'increment']);
Route::post('/dentail_facilities/decrement', [FacilityManagementController::class, 'decrement']);
?>