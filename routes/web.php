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
    // $lessons = json_decode(File::get(storage_path() . "/dummy/home.json"));
    return view('welcome2', compact('lessons'));
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/about', 'AboutController@load');

/*
|--------------------------------------------------------------------------
| All dummy routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/dummy', 'DummyController@load');
// Route::get('/dummy1', 'DummyController@load');		// Example
// Route::get('/lesson{lessonNo}/{activity}', 'DummyController@load');
Route::get('/lesson1/P1', 'P1Controller@load');
Route::get('/lesson1/P2', 'P2Controller@load');
Route::get('/lesson1/P3', 'P3Controller@load');
Route::get('/lesson1/P4', 'P4Controller@load');
Route::get('/lesson1/P5', 'P5Controller@load');
Route::get('/lesson1/P6', 'P6Controller@load');
Route::get('/lesson1/P7', 'P7Controller@load');
Route::get('/lesson1/P8', 'P8Controller@load');
Route::get('/lesson1/P9', 'P9Controller@load');
Route::get('/lesson1/P10', 'P10Controller@load');
Route::get('/lesson1/P11', 'P11Controller@load');
Route::get('/lesson1/P12', 'P12Controller@load');
Route::get('/lesson1/P13', 'P13Controller@load');
Route::get('/lesson1/P14', 'P14Controller@load');
Route::get('/lesson1/extension', 'ExtendController@load');
Route::get('/lesson1/situation', 'SituController@load');
Route::get('/act', function () {
	return view('activities.layout.activityLayout');
});

/*
|--------------------------------------------------------------------------
| End dummy routes
|--------------------------------------------------------------------------
*/

Route::get('/testAnimate', function () {
	return view('testAnimate');
});
