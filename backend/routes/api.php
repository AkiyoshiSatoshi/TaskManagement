<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::apiResource('projects', ProjectController::class);
    Route::put('/tasks/{task}/status', [TaskController::class, 'status']);
	Route::apiResource('projects.tasks', TaskController::class)->shallow();
    Route::get('/projects/{project}/users', [ProjectUserController::class, 'index']);
    Route::post('/projects/{project}/users', [ProjectUserController::class, 'store']);
    Route::delete('/projects/{project}/users/{user}', [ProjectUserController::class, 'destroy']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('tasks.subtasks', SubtaskController::class)->shallow();
    Route::get('/my/account', [AccountController::class, 'fetchMyAccount']);
    Route::put('/my/account', [AccountController::class, 'updateMyAccount']);
});