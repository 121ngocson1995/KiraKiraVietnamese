<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P12GroupInteraction;

class P12Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

    	// Lấy dữ liệu từ db
    	$elementData = P12GroupInteraction::where('lesson_id', '=', $lesson_id)->get();
    	return view("activities.P12", compact('elementData')); 
    }
}
