<?php


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    // Show the homepage
    Route::get('/', 'HomeController@index');

    Route::get('/{id}/edit', 'HomeController@edit');

    // Store a new contact.
    Route::post('/', 'HomeController@store');

    Route::put('/', 'HomeController@update');

    Route::delete('/{id}', 'HomeController@destroy');
});

