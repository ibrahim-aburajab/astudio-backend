<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;

use App\Http\Controllers\API\RegisterController;

Route::get('/', function () {
    return 'this is API';
});


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

Route::post('connectusertoproject/{id}', [UserController::class, 'connectUserToProject'])->middleware('auth:sanctum');
Route::post('disconnectusertoproject/{id}', [UserController::class, 'disconnectUserToProject'])->middleware('auth:sanctum');

Route::post('connectprojecttouser/{id}', [ProjectController::class, 'connectProjectToUser'])->middleware('auth:sanctum');
Route::post('disconnectprojecttouser/{id}', [ProjectController::class, 'disconnectProjectToUser'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('timesheets', TimesheetController::class);



});
