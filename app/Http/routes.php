<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    // Show the homepage.
    Route::get('/', 'HomeController@index');

    // Show the edit page for a contact.
    Route::get('/{id}/edit', 'HomeController@edit');

    // Store a new contact.
    Route::post('/', 'HomeController@store');

    // update an existing contact.
    Route::put('/', 'HomeController@update');

    // Delete a contact.
    Route::delete('/{id}', 'HomeController@destroy');
});

