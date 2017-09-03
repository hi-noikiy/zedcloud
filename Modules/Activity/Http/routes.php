<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'activity', 'namespace' => 'Modules\Activity\Http\Controllers'], function()
{
    Route::get('activity/list', 'ActivityController@index')->name('activity.activity.list');
    Route::get('activity/create', 'ActivityController@create')->name('activity.activity.create');
    Route::post('activity/store', 'ActivityController@store')->name('activity.activity.store');
    Route::delete('activity/{_activity_id}/destroy', 'ActivityController@destroy')->name('activity.activity.destroy');
    Route::get('activity/{_activity_id}/edit', 'ActivityController@edit')->name('activity.activity.edit');
    Route::post('activity/update', 'ActivityController@update')->name('activity.activity.update');
    
    Route::get('activity/{_activity_id}/unsethot', 'ActivityController@unsethot')->name('activity.activity.unsethot');
    Route::get('activity/{_activity_id}/sethot', 'ActivityController@sethot')->name('activity.activity.sethot');
    
});
