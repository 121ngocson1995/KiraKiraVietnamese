<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3SentenceMemorize;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P3Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P3SentenceMemorize::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		return view("activities.P3v2", compact(['elementData', 'cnt']));
	}
}
