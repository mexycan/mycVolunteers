<?php

use Illuminate\Http\Request;

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

Route::post('/clock', 'ApiController@clockHandler');

//Cordinator needs to access pending times per area
Route::get('/pendingtimes/{area_id}', 'ApiController@getPedingTimesByArea');

Route::get('/clock/approve/{clock_id}', 'ApiController@approveClock');
Route::get('/clock/reject/{clock_id}', 'ApiController@rejectClock');
