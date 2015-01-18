<?php

Route::get( '/', ['uses' => 'PublicController@index',  'as' => 'public.index']);
Route::post('/', ['uses' => 'PublicController@create', 'as' => 'public.create']);

Route::group(['prefix' => 'admin'], function()
{
    Route::group(['before' => 'guest'], function() {
        Route::get( '/auth', ['uses' => 'AuthController@index',  'as' => 'auth.index']);
        Route::post('/auth', ['uses' => 'AuthController@login',  'as' => 'auth.login']);
    });

    Route::group(['before' => 'auth'], function() {
        Route::get('/auth/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);
        Route::get('/',            ['uses' => 'AdminController@index', 'as' => 'admin.index']);

        Route::group(['prefix' => 'startups'], function() {
            Route::get(  '/',             ['uses' => 'StartupsController@index',           'as' => 'admin.startups.index']);
            Route::get(  '/{id}/delete',  ['uses' => 'StartupsController@delete',          'as' => 'admin.startups.delete']);
            Route::get(  '/{id}/feature', ['uses' => 'StartupsController@toggleFeatured',  'as' => 'admin.startups.feature']);
            Route::get(  '/{id}/approve', ['uses' => 'StartupsController@approve',         'as' => 'admin.startups.approve']);
            Route::get(  '/{id}/decline', ['uses' => 'StartupsController@decline',         'as' => 'admin.startups.decline']);
            Route::get(  '/{id}/edit',    ['uses' => 'StartupsController@edit',            'as' => 'admin.startups.edit']);
            Route::post( '/{id}/update',  ['uses' => 'StartupsController@update',          'as' => 'admin.startups.update']);
        });

        Route::group(['prefix' => 'users'], function() {
            Route::get( '/',            ['uses' => 'UsersController@index',  'as' => 'admin.users.index']);
            Route::post('/',            ['uses' => 'UsersController@create', 'as' => 'admin.users.create']);
            Route::get( '/{id}/delete', ['uses' => 'UsersController@delete', 'as' => 'admin.users.delete']);
        });
    });
});