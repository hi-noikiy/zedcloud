<?php
Route::get('login', 'LoginController@login')->name('login');
Route::post('login', 'LoginController@check')->name('login');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'SiteController@index')->name('home');
    Route::get('logout', 'SiteController@logout')->name('logout');
    Route::get('link/index', 'SiteController@site')->name('link.index');
    Route::post('process/set', 'SiteController@process_set')->name('process.set');
    Route::post('site/set', 'SiteController@site_set')->name('site.set');
});

Route::get('api/create', 'ApiController@create')->name('user.create');
Route::get('api/get_users', 'ApiController@getUsers')->name('user.get');
