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


Route::resource('items','ItemsController');
Route::resource('requests','UserRequestsController');
Route::get('/requests/{id}', 'UserRequestsController@show')->name('requests');
Route::post('/requests/{id}', 'UserRequestsController@create')->name('requests');
Route::get('/requestsitems', 'UserRequestsController@index')->name('requestsitems');
Route::post('/requestsitems', 'UserRequestsController@update')->name('requestsitems');


Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();


