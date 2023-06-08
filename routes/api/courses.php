<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::post('/courses', [CourseController::class, 'update']);
    Route::get('/courses/{id}', [CourseController::class, 'get']);
    Route::delete('/courses/{id}', [CourseController::class, 'softDelete']);
});
