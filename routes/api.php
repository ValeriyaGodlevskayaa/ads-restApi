<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['as' => 'api.'], function () {
    Route::prefix('/v1/ads/')->group(function (){
        Route::get('/', [\App\Http\Controllers\Api\V1\AdController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\V1\AdController::class, 'getById']);
        Route::post('/create', [\App\Http\Controllers\Api\V1\AdController::class, 'store']);
    });
});

