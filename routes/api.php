<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EtholController;

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\GroupMemberController;
use App\Http\Controllers\Api\SubTaskController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ETHOL login (public — alternative auth method)
Route::post('ethol/login', [EtholController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes (auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('dashboard/{user_id}', [DashboardController::class, 'index']);

    // Users (no store — use register)
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    // Profile Abilities (maps to profile_abilities table in db.sql)
    Route::get('users/{userId}/abilities', [UserController::class, 'abilities']);
    Route::post('users/{userId}/abilities', [UserController::class, 'storeAbility']);
    Route::delete('profile-abilities/{id}', [UserController::class, 'destroyAbility']);

    // Groups
    Route::get('/groups/user/{user_id}', [GroupController::class, 'getByUser']);
    Route::get('/groups/{group_id}', [GroupController::class, 'detail']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::post('/groups/join', [GroupController::class, 'join']);

    // Group Members (nested under groups)
    Route::get('groups/{groupId}/members', [GroupMemberController::class, 'index']);
    Route::post('groups/{groupId}/members', [GroupMemberController::class, 'store']);
    Route::put('group-members/{id}', [GroupMemberController::class, 'update']);
    Route::delete('groups/{groupId}/members/{userId}', [GroupMemberController::class, 'destroy']);

    // Tasks
    Route::prefix('tasks')->group(function () {
        Route::get('/user/{user_id}', [TaskController::class, 'getByUser']);
        Route::get('/{task_id}/detail/{user_id}', [TaskController::class, 'detail']);
        Route::post('/', [TaskController::class, 'store']);
    });

    // Subtasks (maps to subtasks + subtask_progress tables in db.sql)
    Route::post('/tasks/{task_id}/subtasks', [SubTaskController::class, 'store']);
    Route::patch('subtasks/{subtask_id}/progress', [SubTaskController::class, 'updateProgress']);
    Route::delete('subtasks/{id}', [SubTaskController::class, 'destroy']);

    // Task Links (maps to task_links table in db.sql)
    Route::get('tasks/{taskId}/links', [TaskController::class, 'links']);
    Route::post('tasks/{taskId}/links', [TaskController::class, 'storeLink']);
    Route::delete('task-links/{id}', [TaskController::class, 'destroyLink']);

    // Task Files (maps to task_files table in db.sql)
    Route::get('tasks/{taskId}/files', [TaskController::class, 'files']);
    Route::post('tasks/{taskId}/files', [TaskController::class, 'storeFile']);
    Route::delete('task-files/{id}', [TaskController::class, 'destroyFile']);

    // ETHOL Integration (authenticated — requires prior login)
    Route::prefix('ethol')->group(function () {
        Route::post('logout', [EtholController::class, 'logout']);
        Route::get('schedule', [EtholController::class, 'schedule']);
        Route::get('homework', [EtholController::class, 'homework']);
        Route::get('attendance', [EtholController::class, 'attendance']);
        Route::get('token', [EtholController::class, 'token']);
    });
});
