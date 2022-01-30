<?php

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

//publis api, one does not need to have a token to access
Route::post('/V1/login', [App\Http\Controllers\Api\V1\SMSController::class, 
'login'])->name('login');

//protocted apis, one haas to have a token to access
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/V1/sendsms', [App\Http\Controllers\Api\V1\SMSController::class, 
    'sendsms'])->name('sendsms');
});
