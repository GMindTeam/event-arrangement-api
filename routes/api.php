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






Route::get('/hello', ['middleware' => 'cors', function() {
    return 'You did it!';
}]);
Route::get('/option','OptionController@getOptionByEventID')->middleware('cors');
Route::apiResource('/event',  'EventController')->middleware('cors');
Route::apiResource('/response', 'ResponseController')->middleware('cors');

Route::get('/eventid/response', 'ResponseDetailController@getResponseIDByEventID')->middleware('cors');
Route::get('/responsedetail', 'ResponseDetailController@getResponseDetailByResponseID')->middleware('cors');