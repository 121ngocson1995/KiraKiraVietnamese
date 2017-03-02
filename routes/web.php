<?php

use Illuminate\Support\Facades\File;

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
    $lessons = json_decode(File::get(storage_path() . "/dummy/home.json"));
    return view('welcome2', compact('lessons'));
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
Route::get('/lesson{lessonNo}/Situation', 'DummyController@load');
Route::get('/lesson{lessonNo}/P1', 'DummyController@load');
Route::get('/lesson{lessonNo}/P2', 'DummyController@load');
Route::get('/lesson{lessonNo}/P3', 'DummyController@load');
Route::get('/lesson{lessonNo}/P4', 'DummyController@load');
Route::get('/lesson{lessonNo}/P5', 'DummyController@load');
Route::get('/lesson{lessonNo}/P6', 'DummyController@load');
Route::get('/lesson{lessonNo}/P7', 'DummyController@load');
Route::get('/lesson{lessonNo}/P8', 'DummyController@load');
Route::get('/lesson{lessonNo}/P9', 'DummyController@load');
Route::get('/lesson{lessonNo}/P10', 'DummyController@load');
Route::get('/lesson{lessonNo}/P11', 'DummyController@load');
Route::get('/lesson{lessonNo}/P12', 'DummyController@load');
Route::get('/lesson{lessonNo}/P13', 'DummyController@load');
Route::get('/lesson{lessonNo}/P14', 'DummyController@load');
Route::get('/lesson{lessonNo}/P15', 'DummyController@load');
/*
|--------------------------------------------------------------------------
| End dummy routes
|--------------------------------------------------------------------------
*/
