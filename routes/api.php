<?php

use App\Http\Controllers\Auth\{ UserController, AuthController, RoleController, PermissionController };
use App\Http\Controllers\TaskController;
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
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('getPermissionRole/{module}', [PermissionController::class, 'getPermissionRole']);
    Route::resource('permissions', PermissionController::class);
    Route::resource('tasks', TaskController::class);
});