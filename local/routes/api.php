<?php

use Illuminate\Http\Request;
use App\Events\DowntimeCaptured;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:api'],function(){
    Route::post('/realtime','Api\RealtimeApiController@store');
});

Route::group(['middleware'=>'auth:api'],function(){
    // DowntimeCaptured::dispatch('Downtime Captured');
    Route::post('/downtime','Api\DowntimeApiController@store'); 
});

Route::get('/workorder','Api\WorkorderController@getWorkorders');


