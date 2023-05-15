<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'api'], function () {


    Route::post('/login', [AuthController::class, 'login']);


    Route::group(['middleware' => ['auth']], function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh/auth', function () {
            return Auth::user()->load('file');
        });

        Route::controller(TransactionController::class)->group(function () {
            Route::get('/transactions/list', 'index');
            Route::put('/transactions/{id}/state', 'updateState');
            Route::put('/transactions/{id}/details', 'updateDetails');
            Route::post('/transactions/save', 'saveTransaction');
        });

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard/data', 'getDataForSelectedDate');
            Route::get('/dashboard/chart-data', 'getChartData');
            Route::get('/dashboard/top', 'getTop10');
            Route::get('/dashboard/sales-day', 'getSalesByDay');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/users/list', 'index');
            Route::put('/users/{id}/state', 'updateState');
            Route::put('/users/profile', 'updateProfile');
            Route::get('/users/profile', 'getProfile');
            Route::post('/users/save', 'saveUser');
            Route::put('/users/{id}', 'updateUser');
            Route::get('/users/{id}', 'getUser');
            Route::get('/users/roles/permissions', 'getRolePermissions');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('/roles/list', 'index');
            Route::get('/roles/all', 'getAllRoles');
            Route::post('/roles/save', 'saveRole');
            Route::put('/roles/{id}', 'updateRole');
            Route::get('/roles/permissions/{id}', 'getRolePermissions');
            Route::get('/roles/{id}', 'getRole');
        });

        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions/by-module', 'getPermissionsByModule');
        });

        Route::controller(FileController::class)->group(function () {
            Route::get('/files/preloaded', 'getPreloadedImages');
        });
    });
});

Route::get('/{any?}', function () {
    return view('layouts.app');
})->name('basepath')
    ->where('any', '.*');
