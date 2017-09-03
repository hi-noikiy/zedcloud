<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'product', 'namespace' => 'Modules\Product\Http\Controllers'], function()
{
    Route::get('categories', 'CategoryController@index')->name('product.category.list');
    Route::get('categories/create', 'CategoryController@create')->name('product.category.create');
    Route::post('categories', 'CategoryController@store')->name('product.category.store');
    Route::get('categories/{_category_id}/edit', 'CategoryController@edit')->name('product.category.edit');
    Route::put('categories/{_category_id}', 'CategoryController@update')->name('product.category.update');
    Route::get('categories/{_category_id}', 'CategoryController@show')->name('product.category.show');
    Route::delete('categories/{_category_id}', 'CategoryController@destroy')->name('product.category.destroy');

    Route::get('products', 'ProductController@index')->name('product.product.list');
    Route::get('products/create', 'ProductController@create')->name('product.product.create');
    Route::post('products', 'ProductController@store')->name('product.product.store');
    Route::get('products/{_product_id}/edit', 'ProductController@edit')->name('product.product.edit');
    Route::put('products/{_product_id}', 'ProductController@update')->name('product.product.update');
    Route::get('products/{_product_id}', 'ProductController@show')->name('product.product.show');
    Route::delete('products/{_product_id}', 'ProductController@destroy')->name('product.product.destroy');

    Route::get('photos', 'PhotoController@index')->name('product.photo.list');
    Route::get('photos/create', 'PhotoController@create')->name('product.photo.create');
    Route::post('photos', 'PhotoController@store')->name('product.photo.store');
    Route::get('photos/{_photo_id}/edit', 'PhotoController@edit')->name('product.photo.edit');
    Route::put('photos/{_photo_id}', 'PhotoController@update')->name('product.photo.update');
    Route::get('photos/{_photo_id}', 'PhotoController@show')->name('product.photo.show');
    Route::delete('photos/{_photo_id}', 'PhotoController@destroy')->name('product.photo.destroy');
    
    
    Route::get('products/{_product_id}/1', 'ProductController@sethot')->name('product.product.sethot');
    Route::get('products/{_product_id}/0', 'ProductController@unsethot')->name('product.product.unsethot');
    
    
    
    
    
    
    
    
    
    
    
    
});