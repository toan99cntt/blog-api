<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Models\Role;

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

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('password-reset/{token}', [AuthController::class, 'passwordReset'])->name('auth.password_reset');
});

Route::post('/members', [MemberController::class, 'store']);
Route::group(['middleware' => 'auth:member'], function () {
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [MemberController::class, 'index']);
        Route::get('/{id}', [MemberController::class, 'show']);
        Route::post('/{id}', [MemberController::class, 'update']);
        Route::delete('/{id}', [MemberController::class, 'destroy']);
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/all', [BlogController::class, 'getAll']);
        Route::get('/{id}', [BlogController::class, 'show']);
        Route::post('/', [BlogController::class, 'store']);
        Route::post('/{id}', [BlogController::class, 'update']);
        Route::delete('/{id}', [BlogController::class, 'destroy']);
        Route::put('/{id}/status', [BlogController::class, 'updateStatus']);

        Route::post('{id}/like-unlike', [BlogController::class, 'likeAndUnlike']);
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::get('/', [MessageController::class, 'index']);
        Route::get('/{id}', [MessageController::class, 'show']);
        Route::post('/{id}', [MessageController::class, 'sendMessage']);
        Route::post('images/{id}', [MessageController::class, 'sendImages']);
        Route::post('files/{id}', [MessageController::class, 'sendFiles']);
        Route::get('messages/members', [MessageController::class, 'getMemberChat']);
        Route::get('messages/{id}', [MessageController::class, 'getMessages']);
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [CommentController::class, 'index']);
        Route::post('/{blogId}', [CommentController::class, 'store']);
        Route::put('/{id}', [CommentController::class, 'update']);
        Route::delete('/{id}', [CommentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/all', [NotificationController::class, 'getAllNotifications']);
        Route::get('/has-seen/{id}', [NotificationController::class, 'setNotificationSeen']);
    });

});

Route::group(
    [
        'prefix' => 'dashboard',
        'middleware' => [
            'auth:member',
            'roles:' . Role::ROLE_ADMIN . ',' . Role::ROLE_MANAGER
        ]
    ],
    function () {

        Route::get('/', [MemberController::class, 'index']);

});
