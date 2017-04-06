<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P2WordRecognize;
use App\Http\Controllers\LessonController;

class P2Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
    	// get lesson
    	$lesson = LessonController::getLesson($lessonNo);

		// get P2
		$elementData = P2WordRecognize::where('lesson_id', '=', $lesson->id)->get();

		$textRender = array();
		foreach ($elementData as $element) {
			$textRender[] = [
				"id" => $element->id,
				"word" => $element->word
			];
		}

		shuffle($textRender);
		$elementData = $elementData->shuffle();

		return view("activities.P2v2", compact(['elementData', 'textRender']));
	}
}
