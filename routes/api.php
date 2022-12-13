<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PollingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware'        => 'api',
    'prefix'            => 'api/auth',
    'controller'        => AuthController::class
], function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('refresh', 'refresh');
    Route::post('logout', 'logout');
    Route::post('me', 'me');
    Route::post('reset-password', 'resetPassword');
});

Route::group([
    'middleware'        => 'islogin',
    'prefix'            => 'v1/api',
    'controller'        => PollingController::class
], function () {
    Route::post('poll', 'store');
    Route::get('poll', 'getData');
    Route::get('poll/{id}', 'getSpecificData');
    Route::post('poll/{poll_id}/vote/{choice_id}', 'vote');
});