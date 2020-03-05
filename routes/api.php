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


Route::apiResource('/event', 'EventController');
Route::apiResource('/response', 'ResponseController');
Route::get('/option', 'OptionController@getOptionByEventID');
Route::get('/responsedetail', 'ResponseDetailController@getResponseDetailByResponseID');