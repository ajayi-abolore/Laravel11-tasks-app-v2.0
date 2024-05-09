<?php

use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegistrationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//  Authentication Routes .................................................
Route::post('/auth/login', [UserLoginController::class, 'login']);
Route::post('/auth/register', [UserRegistrationController::class, 'register']);
// Authentication ends here ................................................

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/user/details', [UserController::class, 'user']);
    Route::get('/all/tasks', [TaskController::class, 'read']);
    Route::get('/tasks/{id}', [TaskController::class, 'getbyId']);
    Route::post('/add/task', [TaskController::class, 'create']);
    Route::put('/edit/task/{id}', [TaskController::class, 'update']);
    Route::delete('/delete/task/{id}', [TaskController::class, 'delete']);

    // role and permission routes
    Route::post('/roles/{roleId}/assign-permission', [RoleController::class, 'assignPermission']);
    Route::post('/user/{userId}/assign_role/{roleName}', [UserController::class, 'assignRole']);
});
