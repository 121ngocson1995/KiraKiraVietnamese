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

/*
|--------------------------------------------------------------------------
| All dummy routes go below this line
|--------------------------------------------------------------------------
*/

Route::get('/dummy', 'DummyController@load');
Route::get('/lesson{lessonNo}/P1new', function() {
	$filePath = storage_path() . "/dummy/P1.json";
	$dummyData = File::get($filePath);
	$dummy = json_decode($dummyData);
	$firstLineNumber;
	if (count($dummy) != 0)
	{
	    $firstLineNumber = $dummy[0]->lineNumber;
	    return view("P1ani", compact(['dummy', 'lessons', 'firstLineNumber']));
	} else {
	    return view("P1ani", compact(['dummy', 'lessons']));
	}
});
// Route::get('/dummy1', 'DummyController@load');		// Example
Route::get('/lesson{lessonNo}/{activity}', 'DummyController@load');
Route::get('/lesson1/P8', 'P8Controller@load');
/*
|--------------------------------------------------------------------------
| End dummy routes
|--------------------------------------------------------------------------
*/

Route::get('/testAnimate', function () {
	return view('testAnimate');
});

