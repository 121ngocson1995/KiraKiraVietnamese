<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P4SentenceRecognize;

class P4Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
		// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P4SentenceRecognize::where('lesson_id', '=', $lesson_id)->get();

		$textRender = array();
		foreach ($elementData as $element) {
			$textRender[] = [
				"id" => $element->id,
				"sentence" => $element->sentence
			];
		}

		shuffle($textRender);
		$elementData = $elementData->shuffle();

		return view("activities.P4v2", compact(['elementData', 'textRender']));
	}  
}
