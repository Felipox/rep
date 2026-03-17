<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/logout/{id}', [AuthController::class, 'logout']);
    Route::get('/orders', [OrderController::class,'index']);
    Route::get('/me', function(Request $request)
    {
        return $request->user();
        }
        );
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::patch('/orders/{order}', [OrderController::class, 'edit']);
    Route::get('/notifications/{user_id}', [NotificationLogController::class,'index']);
});
