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
Route::get('/option','OptionController@getOptionByEventID')->middleware('cors');
Route::get('/event/{event}',  'EventController@getEventDetailFromEventID')->middleware('cors');
Route::put('/event/{event}',  'EventController@updateEvent')->middleware('cors');
Route::post('/event',  'EventController@createEvent')->middleware('cors');
Route::get('/response/{response}', 'ResponseController@getResponseListFromEventID')->middleware('cors');
Route::post('/response', 'ResponseController@createResponse')->middleware('cors');
Route::delete('/response/{response}', 'ResponseController@deleteResponse')->middleware('cors');
Route::put('/response/{response}', 'ResponseController@editResponse')->middleware('cors');
Route::get('/responsedetail', 'ResponseDetailController@getResponseDetailByResponseID')->middleware('cors');