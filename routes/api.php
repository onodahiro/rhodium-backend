<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\NotesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/survey',  [SurveyController::class, 'saveAnswer']);

Route::get('/go', function () {
    return 'Go proebyvatsa !!!';
});

Route::prefix('notes')->group(function () {
    Route::get('',  [NotesController::class, 'getNotes']);
    Route::get('last-page',  [NotesController::class, 'getLastPage']);
    Route::get('check',  [NotesController::class, 'checkNote']);
    Route::post('save',  [NotesController::class, 'saveNote']);
    Route::get('tag',  [NotesController::class, 'getPreloadTags']);
    Route::post('by-tag',  [NotesController::class, 'getNotesByTag']);
});
