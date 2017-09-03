<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('user/combo/apply', 'UserController@index')->name('user.apply.combo');
    Route::get('user/combo/get', 'UserController@get_user_combo')->name('user.combo.get');
    Route::get('visit/index', 'UserController@visit_index')->name('user.visit.index');
    Route::get('deal', 'UserController@deal')->name('user.deal');
});
