<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [
        'uses' => AccessTokenController::class.'@issueToken',
        'as' => 'login',
        'middleware' => ['format-response-sign-in', 'add-data-response'],
    ]);

    Route::group(['middleware' => 'auth:member'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('info', [AuthController::class, 'info']);
    });
});

Route::post('/members', [MemberController::class, 'store']);
Route::group(['middleware' => 'auth:member'], function () {
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [MemberController::class, 'index']);
        Route::get('/{id}', [MemberController::class, 'show']);
        Route::put('/{id}', [MemberController::class, 'update']);
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/{id}', [BlogController::class, 'show']);
        Route::post('/', [BlogController::class, 'store']);
        Route::put('/{id}', [BlogController::class, 'update']);
        Route::delete('/{id}', [BlogController::class, 'destroy']);
    });
});
Route::group(['middleware' => 'auth:member'], function () {
    Route::group(['prefix' => 'chat'], function () {
        Route::get('/{id}', [MessageController::class, 'show']);
        Route::post('/{id}', [MessageController::class, 'sendMessage']);
        Route::post('images/{id}', [MessageController::class, 'sendImages']);
        Route::post('files/{id}', [MessageController::class, 'sendFiles']);
    });
});
