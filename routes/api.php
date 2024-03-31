<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\Services\ServiceController;
use App\Http\Controllers\Api\Services\ViewServiceAppointmentController;
use App\Http\Controllers\Api\Services\RenewServiceAppointmentController;
use App\Http\Controllers\Api\Services\CreateServiceAppointmentController;
use App\Http\Controllers\Api\Services\DeleteServiceAppointmentController;

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

/**
 * Auth routes
 */
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::post('logout', [UserAuthController::class, 'logout']);
        //Alap route benne hagyom
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::group(['prefix' => 'services'], function () {
        Route::get('/', [ServiceController::class, 'handle']);
        Route::group(['prefix' => '{service_id}'], function () {
            Route::get('/time-table', [ViewServiceAppointmentController::class, 'handle']);
            Route::post('/time-table', [CreateServiceAppointmentController::class, 'handle']);
            Route::delete('/time-table', [DeleteServiceAppointmentController::class, 'handle']);
            Route::patch('/time-table', [RenewServiceAppointmentController::class, 'handle']);
        });
    });
});
