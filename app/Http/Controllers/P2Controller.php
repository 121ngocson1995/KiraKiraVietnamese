<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P2WordRecognize;

class P2Controller extends Controller
{
	public function load()
	{
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P2WordRecognize::where('lesson_id', '=', $lesson_id)->get();

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
