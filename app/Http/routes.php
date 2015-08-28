<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');

Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

route::get('project/{id}/task', 'ProjectTaskController@index');
route::post('project/{id}/task', 'ProjectTaskController@store');
route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');
route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');

route::get('project/{id}/members', 'ProjectMembersController@index');
route::post('project/{id}/members', 'ProjectMembersController@store');
route::get('project/{id}/members/{membersId}', 'ProjectMembersController@isMember');
route::delete('project/{id}/members/{membersId}', 'ProjectMembersController@destroy');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');

