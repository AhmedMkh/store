<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login',    [AuthController::class, 'login']);

    Route::post('/logout',   [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->group(function () {

    Route::get('/my_profile', [AuthController::class, 'my_profile']);

});
