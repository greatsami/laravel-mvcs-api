<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::post('/students', [StudentController::class, 'update']);
    Route::get('/students/{id}', [StudentController::class, 'get']);
    Route::delete('/students/{id}', [StudentController::class, 'softDelete']);
});
