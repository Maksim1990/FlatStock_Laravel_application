<?php


Route::get('/norights', function () {
    return view('includes.norights');
});
Auth::routes();


Route::get('/', 'ApartmentController@appIndex');
Route::get('/show/{id}', 'ApartmentController@show');
Route::group(['middleware' => 'admin'], function () {

    Route::resource('/item', 'ApartmentController');
    Route::get('/mongo', 'UserController@mongo');
    Route::get('/appart', 'ApartmentController@createApartment');
    Route::get('/all', 'ApartmentController@all');
    Route::get('/create', 'ApartmentController@create');
    Route::post('/store', 'ApartmentController@store');
    Route::get('/edit/{id}', 'ApartmentController@edit');
    Route::get('/delete/{id}', 'ApartmentController@destroy');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/ajax', 'ApartmentController@ajax');
    Route::post('/add_apartment_ajax', 'ApartmentController@addApartment');
    Route::post('/edit_apartment_ajax', 'ApartmentController@editApartment');
    Route::post('/add_image_description_ajax', 'DescriptionController@addDescription');
    Route::post('/delete_image_description_ajax', 'DescriptionController@deleteDescription');
    Route::post('/delete_image_ajax', 'ImageController@deleteImage');

});