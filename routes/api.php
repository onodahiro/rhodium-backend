<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;

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

Route::prefix('user')->group(function () {
    Route::get('',  [UserController::class, 'getUser'])->middleware('auth:sanctum');
    Route::post('login',  [UserController::class, 'login']);
    Route::get('logout',  [UserController::class, 'logout'])->middleware('auth:sanctum');;
    Route::post('registration',  [UserController::class, 'registration']);
    Route::get('send-verify-code',  [UserController::class, 'sendVerifyCode'])->middleware('auth:sanctum');
    Route::get('verify-email',  [UserController::class, 'verifyEmail'])->middleware('auth:sanctum');
    Route::patch('change-email',  [UserController::class, 'changeEmail'])->middleware('auth:sanctum');
    Route::patch('change-password',  [UserController::class, 'changePassword'])->middleware('auth:sanctum');
    Route::get('send-lost-pass-email',  [UserController::class, 'sendLostPassEmail']);
    Route::get('check-lost-pass-code',  [UserController::class, 'checkLostPassCode']);
    Route::post('set-lost-password',  [UserController::class, 'setLostPassword']);
});

Route::post('/survey',  [SurveyController::class, 'saveAnswer']);

Route::prefix('notes')->group(function () {
    Route::get('',  [NotesController::class, 'getNotes']);
    Route::get('last-page',  [NotesController::class, 'getLastPage']);
    Route::get('check',  [NotesController::class, 'checkNote']);
    Route::post('save',  [NotesController::class, 'createNote']);
    Route::get('tag',  [NotesController::class, 'getPreloadTags']);
    Route::post('by-tag',  [NotesController::class, 'getNotesByTag']);
});

Route::prefix('/records')->group(function () {
    Route::get('/',  [RecordsController::class, 'getRecords']);
    Route::post('/',  [RecordsController::class, 'createRecord']);
    Route::get('/type',  [RecordsController::class, 'getTypes']);
    Route::post('/type',  [RecordsController::class, 'createType']);
});
