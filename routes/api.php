<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function (){
    
    // Authentication routes
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/logout',[AuthController::class, 'logout']);
        Route::get('/me',[AuthController::class, 'me']);
        // Profile routes
        Route::patch('/profile',[ProfileController::class, 'update']);


         // Get trashed tasks
          Route::get('/tasks/summary', [TaskController::class, 'summary']);
         Route::get('tasks/trashed', [TaskController::class, 'trashed']);
       
        Route::post('tasks/{id}/restore', [TaskController::class, 'restore']);
        Route::delete('tasks/{id}/force', [TaskController::class, 'forceDelete']);
        Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus']);
       

        
         // Task routes
         Route::apiResource('tasks',TaskController::class);

       
       

        //filter tasks by status
        Route::get('/tasksfilter', [TaskController::class, 'filter']);
       

        
        

    });
});
