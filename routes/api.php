<?php

use App\Http\Controllers\Api\AbilityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EtholController;

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\GroupMemberController;
use App\Http\Controllers\Api\SubTaskAssignmentController;
use App\Http\Controllers\Api\SubTaskController;
use App\Http\Controllers\Api\SupportFileController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskGenerationController;
use App\Http\Controllers\Api\UserAbilityController;
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

    // Abilities CRUD
    Route::apiResource('abilities', AbilityController::class);

    // User Abilities (nested under users)
    Route::get('users/{userId}/abilities', [UserAbilityController::class, 'index']);
    Route::post('users/{userId}/abilities', [UserAbilityController::class, 'store']);
    Route::put('user-abilities/{id}', [UserAbilityController::class, 'update']);
    Route::delete('user-abilities/{id}', [UserAbilityController::class, 'destroy']);

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

    //Sub Task
    Route::post('/tasks/{task_id}/subtasks', [SubTaskController::class, 'store']);
    Route::patch('subtasks/{subtask_id}/status', [SubTaskController::class, 'updateStatus']);
    Route::delete('subtasks/{id}', [SubTaskController::class, 'destroy']);

    // Sub Task Assignments (nested under sub-tasks)
    Route::get('sub-tasks/{subTaskId}/assignments', [SubTaskAssignmentController::class, 'index']);
    Route::post('sub-tasks/{subTaskId}/assignments', [SubTaskAssignmentController::class, 'store']);
    Route::put('sub-task-assignments/{id}', [SubTaskAssignmentController::class, 'update']);
    Route::delete('sub-task-assignments/{id}', [SubTaskAssignmentController::class, 'destroy']);

    // Support Files (nested under tasks)
    Route::get('tasks/{taskId}/files', [SupportFileController::class, 'index']);
    Route::post('tasks/{taskId}/files', [SupportFileController::class, 'store']);
    Route::get('support-files/{id}', [SupportFileController::class, 'show']);
    Route::delete('support-files/{id}', [SupportFileController::class, 'destroy']);

    // Task Generations (nested under tasks)
    Route::get('tasks/{taskId}/generations', [TaskGenerationController::class, 'index']);
    Route::post('tasks/{taskId}/generations', [TaskGenerationController::class, 'store']);
    Route::get('task-generations/{id}', [TaskGenerationController::class, 'show']);
    Route::delete('task-generations/{id}', [TaskGenerationController::class, 'destroy']);

    // ETHOL Integration (authenticated — requires prior login)
    Route::prefix('ethol')->group(function () {
        Route::post('logout', [EtholController::class, 'logout']);
        Route::get('schedule', [EtholController::class, 'schedule']);
        Route::get('homework', [EtholController::class, 'homework']);
        Route::get('attendance', [EtholController::class, 'attendance']);
        Route::get('token', [EtholController::class, 'token']);
    });
});
