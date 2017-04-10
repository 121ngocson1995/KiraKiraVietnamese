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
Route::get('/lessons', 'AboutController@load');

/*
|--------------------------------------------------------------------------
| All dummy routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/dummy', 'DummyController@load');
// Route::get('/dummy1', 'DummyController@load');		// Example
// Route::get('/lesson{lessonNo}/{activity}', 'DummyController@load');
//start route dummy
Route::get('/userManage', 'UserController@load');
Route::get('/editUser', 'UserController@edit');
Route::get('/preAddLesson', 'LessonController@preAdd');
Route::get('/addLesson', 'LessonController@add');
//end route dummy
Route::get('/lesson1/p1', 'P1Controller@load');
Route::get('/lesson1/p2', 'P2Controller@load');
Route::get('/lesson1/p3', 'P3Controller@load');
Route::get('/lesson1/p4', 'P4Controller@load');
Route::get('/lesson1/p5', 'P5Controller@load');
Route::get('/lesson1/p6', 'P6Controller@load');
Route::get('/lesson1/p7', 'P7Controller@load');
Route::get('/lesson1/p8', 'P8Controller@load');
Route::get('/lesson1/p9', 'P9Controller@load');
Route::get('/lesson1/p10', 'P10Controller@load');
Route::get('/lesson1/p11', 'P11Controller@load');
Route::get('/lesson1/p12', 'P12Controller@load');
Route::get('/lesson1/p13', 'P13Controller@load');
Route::get('/lesson1/p14', 'P14Controller@load');
Route::get('/lesson1/extensions', 'ExtendController@load');
Route::get('/lesson1/situations', 'SituController@load');
Route::get('/act', function () {
	return view('activities.layout.activityLayout');
});

/*ádas
|--------------------------------------------------------------------------
| End dummy routes
|--------------------------------------------------------------------------
*/

Route::get('/testAnimate', function () {
	return view('testAnimate');
});
