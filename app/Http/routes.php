<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function () {

    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

//    Route::group(['middleware' => 'CheckProjectOwner'], function () {
//        Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
//    });

    Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);

    Route::group(['prefix' => 'project/{projectId}'], function () {

        Route::get('note', 'ProjectNoteController@index');
        Route::post('note', 'ProjectNoteController@store');
        Route::get('note/{id}', 'ProjectNoteController@show');
        Route::delete('note/{id}', 'ProjectNoteController@destroy');
        Route::put('note/{id}', 'ProjectNoteController@update');

        Route::get('task', 'ProjectTaskController@index');
        Route::post('task', 'ProjectTaskController@store');
        Route::get('task/{id}', 'ProjectTaskController@show');
        Route::delete('task/{id}', 'ProjectTaskController@destroy');
        Route::put('task/{id}', 'ProjectTaskController@update');

        Route::get('member', 'ProjectMemberController@members');
        Route::post('member', 'ProjectMemberController@addMember');
        Route::delete('member/{userId}', 'ProjectMemberController@removeMember');
        Route::get('member/{userId}', 'ProjectMemberController@isMember');

        Route::post('file', 'ProjectFileController@store');
        Route::delete('file', 'ProjectFileController@destroy');
    });

});


