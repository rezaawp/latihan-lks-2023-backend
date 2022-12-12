<?php

use App\Http\Controllers\AuthController;
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
    'prefix'            => 'auth',
    'controller'        => AuthController::class
], function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('refresh', 'refresh');
    Route::post('logout', 'logout');
    Route::post('me', 'me');
    Route::post('reset-password', 'resetPassword');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('tes', 'tes');
});

// Route::get('tes', function () {
//     return 'hai';
// });
