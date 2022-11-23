<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('user.login');
        Route::post('register', [AuthController::class, 'register'])->name('user.register');
        Route::group(['middleware' => ['jwt.verify']], function () {
            Route::get('refresh', [AuthController::class, 'refresh'])->name('user.refresh');
            Route::get('user', [AuthController::class, 'getUser'])->name('user.detail');
            Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
        });
        Route::prefix('user')->group(function () {
            Route::resource('user', UserController::class);
            Route::post('delete', [AuthController::class, 'deleteUser'])->name('user.delete');
        });
    });
});
