<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MasterQuestionController;
use App\Http\Controllers\Dashboard\SurveyController;
use App\Http\Controllers\Dashboard\SurveyDetailController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard
Route::prefix('admin')->namespace('admin')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/questions', [MasterQuestionController::class, 'index'])->name('master-questions');
  Route::get('/survey', [SurveyController::class, 'index'])->name('survey');
  Route::get('/survey/detail/{id}', [SurveyDetailController::class, 'index'])->name('survey-detail');
});
