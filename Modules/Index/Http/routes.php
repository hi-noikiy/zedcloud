<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'index', 'namespace' => 'Modules\Index\Http\Controllers'], function()
{
    Route::get('list', 'IndexController@index')->name('index.index.list');
    Route::post('add/lunbo', 'IndexController@lunbo_create')->name('index.lunbo.create');
    Route::get('edit/{_lunbo_id}/lunbo', 'IndexController@lunbo_edit')->name('index.lunbo.edit');
    Route::post('update/lunbo', 'IndexController@lunbo_update')->name('index.lunbo.update');
    
    Route::post('add/notice', 'IndexController@notice_create')->name('index.notice.create');
    Route::post('add/about', 'IndexController@about_create')->name('index.about.create');
    

    
    Route::delete('remove/{_lunbo_id}/lunbo', 'IndexController@lunbo_remove')->name('index.lunbo.remove');
    
    Route::post('add/us', 'IndexController@us_create')->name('index.us.create');
    Route::post('edit/us', 'IndexController@us_edit')->name('index.us.edit');
    
    Route::get('create/us', 'IndexController@create_abort')->name('abort.us.create');
    
    Route::post('add/gift', 'IndexController@gift_create')->name('index.gift.create');
    Route::post('update/gift', 'IndexController@gift_update')->name('index.gift.update');
    Route::delete('remove/{_gift_id}/gift', 'IndexController@gift_remove')->name('index.gift.remove');
    
});
