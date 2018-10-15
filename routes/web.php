<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
 return view('welcome');
});

// Route::get('/images', 'ImageController@index');     
// Route::get('/images/create', 'ImageController@create');
// Route::post('/images', 'ImageController@store');
// Route::get('/images/{id}', 'ImageController@show');
// Route::get('/images/{id}/edit', 'ImageController@edit');
// Route::patch('/images/{id}', 'ImageController@update');
// Route::delete('/images/{id}', 'ImageController@destroy');

Route::resource('images', 'ImageController');

Route::get('/view', 'GalleryController@index');     //Responsible for displaying a view to display the gallery
