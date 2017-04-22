<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Lesson;


class AboutController extends Controller
{
     public function load()
    {
    	// Dummy course and lesson
        // コースとレッスンをダミーする。
		$course_id= 1;
    	
    	// Load data from Database
        // データベースからデータをロードする。
    	$courseData = Course::where('id', '=', $course_id)->get();
    	$lessonData = Lesson::where('course_id', '=', $course_id)->get();
    	$lessonCnt = count($lessonData);
    	for ($i=0; $i<$lessonCnt; $i++){
            $descripArr[$i] = $lessonData[$i]->description;
        }

        return view('about', compact(['lessonData', 'courseData', 'lessonCnt', 'descripArr']));
    }
}
