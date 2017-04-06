<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;

class LessonController extends Controller
{
	public static function getLesson($lessonNo, $course_id = 1)
	{
		// \DB::listen(function($query) {
		// 	dd($query->sql);
		// });
		$lesson = Lesson::where('lessonNo', '=', $lessonNo)->first();
		return $lesson;
	}
}
