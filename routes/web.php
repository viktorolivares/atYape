<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\IpController;
use Illuminate\Support\Facades\Route;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['prefix' => 'api'], function () {

    Route::group(['middleware' => ['auth']], function () {

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
            Route::put('/transactions/update/{id}', 'updateTransaction');
            Route::delete('/transactions/delete/{id}', 'deleteTransaction');
            Route::get('/transactions/pendings', 'searchPending');
            Route::get('/transactions/description/{description}', 'listByDescription');
        });

        /*DNI Deceased + Minors*/
        Route::controller(DeceasedController::class)->group(function () {
            Route::get('/dni/query', 'getDni');
            Route::post('/dni/minors-deceased', 'getMinorsDeceased');
            Route::post('/dni/cookies-captcha', 'getCookiesCaptcha');
        });

        /*Logs*/
        Route::controller(LogsController::class)->group(function () {
            Route::get('/logs/list', 'index');
            Route::get('/logs/github', 'github');
            Route::post('/logs/save', 'logs');
        });

        /*Permisos*/
        Route::get('/permissions/by-module', [PermissionController::class, 'getPermissionsByModule']);

        /*Files*/
        Route::get('/files/preloaded', [FileController::class, 'getPreloadedImages']);

        /*Consulta IP*/
        Route::get('/ip/query', [IpController::class, 'ipConsult']);

        /*Domain*/
        Route::get('/domain/list', [DomainController::class, 'index']);

    });
});

Route::get('/{any?}', function () {
    return view('app');
})->name('basepath')
    ->where('any', '.*');
