<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionApiController;


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

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(TransactionApiController::class)->group(function () {
        Route::post('/transactions/saveApk', 'saveTransaction');
        Route::get('/transactions/listApk', 'listTransactions');
    });
});
