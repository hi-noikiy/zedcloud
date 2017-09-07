<?php

Route::group(['middleware' => 'web', 'prefix' => 'shop', 'namespace' => 'Modules\Shop\Http\Controllers'], function()
{
    Route::get('index', 'ShopController@index')->name('shop.shop.index');
    Route::get('edit/{shop_id}', 'ShopController@edit')->name('shop.shop.edit');
    Route::post('shop/create', 'ShopController@store')->name('shop.shop.store');
    Route::delete('shop/{shop_id}', 'ShopController@destroy')->name('shop.shop.destroy');
    Route::get('shop/{shop_id}', 'ShopController@undestroy')->name('shop.shop.undestroy');
    Route::post('shop', 'ShopController@update')->name('shop.shop.update');
    


});
