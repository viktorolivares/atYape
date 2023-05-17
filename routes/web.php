<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

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

        /*Funciones Extras*/
        Route::get('/refresh/auth', function () {
            return Auth::user()->load('file');
        });

        Route::get('/check-session', function (Request $request) {
            if ($request->session()->has('userId')) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'unauthorized'], 401);
            }
        });

        /*Dashboard*/
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard/data', 'getDataForSelectedDate');
            Route::get('/dashboard/chart-data', 'getChartData');
            Route::get('/dashboard/top', 'getTop10');
            Route::get('/dashboard/sales-day', 'getSalesByDay');
        });

        /*Users*/
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

        /*Roles*/
        Route::controller(RoleController::class)->group(function () {
            Route::get('/roles/list', 'index');
            Route::get('/roles/all', 'getAllRoles');
            Route::post('/roles/save', 'saveRole');
            Route::put('/roles/{id}', 'updateRole');
            Route::get('/roles/permissions/{id}', 'getRolePermissions');
            Route::get('/roles/{id}', 'getRole');
        });

        /*Transacciones*/
        Route::controller(TransactionController::class)->group(function () {
            Route::get('/transactions/list', 'index');
            Route::put('/transactions/{id}/state', 'updateState');
            Route::put('/transactions/{id}/details', 'updateDetails');
            Route::post('/transactions/save', 'saveTransaction');
            Route::get('/transactions/description/{description}', 'listByDescription');
        });

        /*Permisos*/
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions/by-module', 'getPermissionsByModule');
        });

        /*Files*/
        Route::controller(FileController::class)->group(function () {
            Route::get('/files/preloaded', 'getPreloadedImages');
        });

        /*Consulta IP*/
        Route::get('/ip', [IpController::class, 'ip'])->name('ip');
        Route::get('/ip-consult/{ip}', [IpController::class, 'ipConsult'])->name('ip-consult');

        /*Domain*/
        Route::get('/domain', [DomainController::class, 'domain'])->name('domain');
        Route::get('/domain-consult/{domain}', [DomainController::class, 'getDomain'])->name('domain-consult');

        /*DNI Deceased + Minors*/
        Route::get('/deceased', [DeceasedController::class, 'index'])->name('dni-deceased');
        Route::post('/query-deceased', [DeceasedController::class, 'getDni'])->name('query-deceased');
        Route::get('/captcha', [DeceasedController::class, 'getCaptcha'])->name('captcha');
    });
});

Route::get('/{any?}', function () {
    return view('layouts.app');
})->name('basepath')
    ->where('any', '.*');
