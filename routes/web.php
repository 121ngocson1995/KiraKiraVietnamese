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
    return view('welcome2');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| All dummy routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/dummy', 'DummyController@load');
// Route::get('/dummy1', 'DummyController@load');		// Example
Route::get('/Situation', 'DummyController@load');
Route::get('/P1', 'DummyController@load');
Route::get('/P2', 'DummyController@load');
Route::get('/P3', 'DummyController@load');
Route::get('/P4', 'DummyController@load');
Route::get('/P5', 'DummyController@load');
Route::get('/P6', 'DummyController@load');
Route::get('/P7', 'DummyController@load');
Route::get('/P8', 'DummyController@load');
Route::get('/P9', 'DummyController@load');
Route::get('/P10', 'DummyController@load');
Route::get('/P11', 'DummyController@load');
Route::get('/P12', 'DummyController@load');
Route::get('/P13', 'DummyController@load');
Route::get('/P14', 'DummyController@load');
Route::get('/P15', 'DummyController@load');
/*
|--------------------------------------------------------------------------
| End dummy routes
|--------------------------------------------------------------------------
*/
