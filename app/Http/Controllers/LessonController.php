<?php

namespace App\Http\Controllers;
use App\Course;
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

    public function preAdd()
    {
    	// dummy course và lesson
		$course_id= 1;
    	
    	// Lấy dữ liệu từ db

    	$courseData = Course::where('id', '=', $course_id)->get();
    	$lessonData = Lesson::where('course_id', '=', $course_id)->get();
    	$lessonCnt = count($lessonData);
    	for ($i=0; $i<$lessonCnt; $i++){
            $lessonList[$i]['lessonNo'] = $lessonData[$i]->lessonNo;
            $lessonList[$i]['lessonName'] = $lessonData[$i]->lesson_name;
        }

        return view('add', compact('lessonList'));
    }

    public function add(Request $request)
    {
    	// dummy course và lesson
		$course_id= 1;
    	
    	// Lấy dữ liệu từ db

    	$lessonNew = new Lesson;
    	$lessonNew-
        return view('add', compact('lessonList'));
    }
}
