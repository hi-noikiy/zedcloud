<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'album', 'namespace' => 'Modules\Album\Http\Controllers'], function () {

    Route::get('albums', 'AlbumController@index')->name('album.album.list');
    Route::get('albums/create', 'AlbumController@create')->name('album.album.create');
    Route::post('albums', 'AlbumController@store')->name('album.album.store');
    Route::get('albums/{_album_id}/edit', 'AlbumController@edit')->name('album.album.edit');
    Route::put('albums/{_album_id}', 'AlbumController@update')->name('album.album.update');
    Route::get('albums/{_album_id}', 'AlbumController@show')->name('album.album.show');
    Route::delete('albums/{_album_id}', 'AlbumController@destroy')->name('album.album.destroy');
    Route::get('albums/{_album_id}/unsethot', 'AlbumController@unsethot')->name('album.album.unsethot');
    Route::get('albums/{_album_id}/sethot', 'AlbumController@sethot')->name('album.album.sethot');
    
    Route::get('photos', 'PhotoController@index')->name('album.photo.list');
    Route::get('photos/create', 'PhotoController@create')->name('album.photo.create');
    Route::post('photos', 'PhotoController@store')->name('album.photo.store');
    Route::get('photos/{_photo_id}/edit', 'PhotoController@edit')->name('album.photo.edit');
    Route::put('photos/{_photo_id}', 'PhotoController@update')->name('album.photo.update');
    Route::get('photos/{_photo_id}', 'PhotoController@show')->name('album.photo.show');
    Route::delete('photos/{_photo_id}', 'PhotoController@destroy')->name('album.photo.destroy');
    Route::post('photos/addpics', 'PhotoController@addpics')->name('album.aubum.addpics');
    
});

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'api/album', 'namespace' => 'Modules\Album\Http\Controllers'], function () {
    Route::post('photos', 'PhotoController@apiStore')->name('api.album.photo.store');
});