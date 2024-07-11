<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Http\Middleware\ChoiceTasksMiddleware;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/tasks/all', [TasksController::class, 'findAllTasks']);
    Route::apiResource('/tasks', TasksController::class);
    Route::post('/tasks', [TasksController::class, 'store'])->middleware(CheckAdminMiddleware::class);
    Route::get('/tasks', [TasksController::class, 'index'])->middleware(ChoiceTasksMiddleware::class);
});

Route::apiResource('/users', UsersController::class);
Route::post('/login', [LoginController::class, 'login'])->name('login');