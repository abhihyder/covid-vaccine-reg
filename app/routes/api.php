<?php

use App\Http\Controllers\VaccineCenterController;
use App\Http\Controllers\VaccineController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/vaccine-centers', [VaccineCenterController::class, 'index']);
Route::post('/register', [VaccineController::class, 'register']);
Route::get('/search/{nid}', [VaccineController::class, 'searchSchedule']);
