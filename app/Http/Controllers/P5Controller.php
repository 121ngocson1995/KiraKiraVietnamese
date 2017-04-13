<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P5DialogueMemorize;

class P5Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
		// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P5DialogueMemorize::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
		$cnt = count($elementData);
		
		return view("activities.P5v2", compact(['elementData', 'contentArr', 'audioArr', 'cnt']));
	}  
}
