<?php

use App\Http\Controllers\Dashboard\MasterQuestionController;
use App\Http\Controllers\Dashboard\SurveyController;
use Illuminate\Http\Request;
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

Route::post('question/create', [MasterQuestionController::class, 'addQuestion']);
Route::post('question/update', [MasterQuestionController::class, 'updateQuestion']);
Route::get('question/dataTable', [MasterQuestionController::class, 'dataTable']);
Route::get('question/list', [MasterQuestionController::class, 'list']);
Route::get('question/{id}/detail',[MasterQuestionController::class, 'getDetail']);
Route::delete('question/delete', [MasterQuestionController::class, 'destroy']);

Route::post('survey/create', [SurveyController::class, 'create']);
Route::get("survey/dataTable", [SurveyController::class, 'dataTable']);
Route::get("survey/{id}/detail", [SurveyController::class, 'getDetail']);
Route::delete('survey/delete', [SurveyController::class, 'destroy']);
