<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P4SentenceRecognize;

class P4Controller extends Controller
{
	public function load()
	{
		// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

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
