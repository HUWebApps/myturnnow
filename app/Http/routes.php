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

Route::get('raisehand', ['as'=>'raisehand', 'uses'=>'HandController@raisehand']);

Route::get('meeting', ['as'=>'main', 'uses'=>'MeetingController@main']);

Route::get('callon', 'HandController@callon');

Route::get('unraise', 'HandController@unraise');
Route::get('transfer', 'HandController@transfer');
Route::get('pusher', 'MeetingController@pusher');
Route::get('pusherclient', ['as'=>'client', 'uses'=>'MeetingController@pusherclient']);
Route::get('ajaxtest', ['as'=>'ajax', 'uses'=>'MeetingController@ajaxtest']);
Route::get('javascriptest', 'MeetingController@javascriptest');
Route::get('ajax', ['as'=>'ajaxactual', 'uses'=>'MeetingController@ajax']);
Route::get('whole', function(){
  return view('testwhole');
});
Route::get('/chart/{id}', 'MeetingController@chart');
