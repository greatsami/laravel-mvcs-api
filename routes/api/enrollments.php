<?php

use App\Http\Controllers\StudentCourseEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::post('/enrollments', [StudentCourseEnrollmentController::class, 'update']);
    Route::get('/enrollments/{id}', [StudentCourseEnrollmentController::class, 'get']);
    Route::delete('/enrollments/{id}', [StudentCourseEnrollmentController::class, 'softDelete']);
});
