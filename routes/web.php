<?php

use Illuminate\Support\Facades\Route;


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



Route::get('/', 'PagesController@index' );


//Route::resource('items','ItemsController');
Route::get('items','ItemsController@index')->name('items');
Route::get('/shows/{id}','ItemsController@show')->name('shows');
Route::get('create', 'ItemsController@create')->name('create');
Route::post('create', 'ItemsController@store')->name('create');
Route::get('edit/{id}','ItemsController@edit')->name('edit');
Route::post('edit/{id}', 'ItemsController@update')->name('edit');
Route::get('/shows/{id}/destroy', 'ItemsController@destroy')->name('destroy');


//Route::resource('requests','UserRequestsController');
Route::get('/requests/{id}', 'UserRequestsController@show')->name('requests');
Route::post('/requests/{id}', 'UserRequestsController@create')->name('requests');
Route::get('/requestsitems', 'UserRequestsController@index')->name('requestsitems');
Route::post('/requestsitems', 'UserRequestsController@update')->name('requestsitems');
Route::get('/requestsitems/destroy/{id}', 'UserRequestsController@destroy')->name('destroyrequest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


