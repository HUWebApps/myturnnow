<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MeetingController@newsession');

//Route::get('/test', 'HandController@test');

Route::post('/meeting/new', 'MeetingController@postNewSession');

//Route::get('/moderator/{id}',['as'=>'moderator page', 'uses'=>'MeetingController@getModerator']);

Route::get('/signin/{id}', ['as'=>'signin', 'uses'=>'HandController@getSignIn']);

Route::post('meeting/signup/{id}', 'HandController@postSignIn');

Route::get('raisehand/{follow}', ['as'=>'raisehand', 'uses'=>'HandController@raisehand']);

Route::get('meeting', ['as'=>'main', 'uses'=>'MeetingController@main']);

Route::get('callon/{id}', 'HandController@callon');

Route::get('unraise/{id}', 'HandController@unraise');
Route::get('transfer/{id}', 'HandController@transfer');
