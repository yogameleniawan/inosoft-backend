<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KendaraanController;
use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\MotorController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Models\Transaction;
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
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::prefix('resources')->group(function () {
            Route::resources([
                'mobil' => MobilController::class,
                'motor' =>  MotorController::class,
                'kendaraan' =>  KendaraanController::class,
                'transaction' =>  TransactionController::class,
                'user' =>  UserController::class,
            ]);
        });

        Route::prefix('reports')->group(function () {
            Route::get('/stok', [ReportController::class, 'getStok'])->name('report.stok');
            Route::get('/total-penjualan', [ReportController::class, 'getPenjualan'])->name('report.penjualan');
            Route::post('/penjualan-kendaraan', [ReportController::class, 'getPenjualanKendaraan'])->name('report.penjualan.kendaraan');
        });
    });
});
