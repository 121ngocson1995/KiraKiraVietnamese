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

/*
|--------------------------------------------------------------------------
| All web access routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // $lessons = json_decode(File::get(storage_path() . "/dummy/home.json"));
	return view('welcome2', compact('lessons'));
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/lessons', 'AboutController@load');
Route::get('/lesson{lessonNo}/p1', 'P1Controller@load');
Route::get('/lesson{lessonNo}/p2', 'P2Controller@load');
Route::get('/lesson{lessonNo}/p3', 'P3Controller@load');
Route::get('/lesson{lessonNo}/p4', 'P4Controller@load');
Route::get('/lesson{lessonNo}/p5', 'P5Controller@load');
Route::get('/lesson{lessonNo}/p6', 'P6Controller@load');
Route::get('/lesson{lessonNo}/p7', 'P7Controller@load');
Route::get('/lesson{lessonNo}/p8', 'P8Controller@load');
Route::get('/lesson{lessonNo}/p9', 'P9Controller@load');
Route::get('/lesson{lessonNo}/p10', 'P10Controller@load');
Route::get('/lesson{lessonNo}/p11', 'P11Controller@load');
Route::get('/lesson{lessonNo}/p12', 'P12Controller@load');
Route::get('/lesson{lessonNo}/p13', 'P13Controller@load');
Route::get('/lesson{lessonNo}/p14', 'P14Controller@load');
Route::get('/lesson{lessonNo}/extensions', 'ExtendController@load');
Route::get('/lesson{lessonNo}/situations', 'SituController@load');

/*
|--------------------------------------------------------------------------
| END of web access routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| All web manage routes go below this line
|--------------------------------------------------------------------------
*/

//start route dummy 
Route::get('/userManage', 'UserController@load');
Route::post('/editUser', 'UserController@edit');
Route::get('/preAddLesson', 'LessonController@preAdd');
Route::get('/addLesson', 'LessonController@add');
Route::get('/listLesson', 'LessonController@listLesson');
Route::get('/preEditLesson{lessonNo}', 'LessonController@preEdit');
Route::get('/editLesson', 'LessonController@edit');
Route::get('/listAct{lessonId}', 'LessonController@listAct');
Route::get('/deleteLesson{lessonNo}', 'LessonController@delete');
Route::get('/lesson{lessonId}/preEdit{activityName}', 'LessonController@preEditAct');
Route::post('/editSitu', 'SituController@edit');
// Route::get('/users', 'UserController@index');
Route::resource('/users', 'UserController');
Route::post('/setRole', 'UserController@setRole');

Route::post('/editP1', 'P1Controller@edit');
Route::post('/editP2', 'P2Controller@edit');

    //end route dummy
Route::get('/dummy', 'DummyController@load');
// Route::get('/dummy1', 'DummyController@load');		// Example
// Route::get('/lesson{lessonNo}/{activity}', 'DummyController@load');

/*
|--------------------------------------------------------------------------
| END of manage access routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| All web testing routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/act', function () {
	return view('activities.layout.activityLayout');
});
Route::get('/test', function () {
	return view('test');
});



Route::group(['domain' => 'manage.localhost', 'domain' => 'manage1.localhost'], function () {
    //start route dummy 
    // Route::get('/userManage', 'UserController@load');
    // Route::post('/editUser', 'UserController@edit');
    // Route::get('/preAddLesson', 'LessonController@preAdd');
    // Route::get('/addLesson', 'LessonController@add');
    // Route::get('/listLesson', 'LessonController@listLesson');
    // Route::get('/preEditLesson{lessonNo}', 'LessonController@preEdit');
    // Route::get('/editLesson', 'LessonController@edit');
    // Route::get('/listAct{lessonId}', 'LessonController@listAct');
    // Route::get('/deleteLesson{lessonNo}', 'LessonController@delete');
    // Route::get('/lesson{lessonId}/preEdit{activityName}', 'LessonController@preEditAct');
    // Route::post('/editSitu', 'SituController@edit');
    //end route dummy
});

/*
|--------------------------------------------------------------------------
| END of manage access routes
|--------------------------------------------------------------------------
*/