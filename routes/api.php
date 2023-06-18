<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/searchByName', [UserController::class, "searchByName"]);
    Route::group([
        'prefix' => "chats"
        ], function (){
            Route::post('/store', [ChatController::class, "store"]);
            Route::get('/user/{id}', [ChatController::class, "get_user_chats"]);
        }
    );
    Route::group([
        'prefix' => "messages"
        ], function (){
            Route::post('/store', [MessageController::class, "store"]);
            Route::get('/chat/{id}', [MessageController::class, "get_chat_messages"]);
        }
    );
});

Route::group([
    'prefix' => "auth"
    ], function (){
        Route::post('/register', [AuthController::class, "register"]);
        Route::post('/login', [AuthController::class, "login"]);
        Route::post('/authentication', [AuthController::class, "authentication"]);
    }
);
