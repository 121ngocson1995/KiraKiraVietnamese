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
		// $cnt = count($elementData);
		// $lastIndex = $elementData[$cnt-1]->correctOrder;
        // $elementData = $elementData->shuffle();      

		$textRender = array();
		foreach ($elementData as $element) {
			$textRender[] = [
				"id" => $element->id,
				"word" => $element->word
			];
		}

		shuffle($textRender);
		$elementData = $elementData->shuffle();

		// dd($elementData);

		return view("activities.P2ani", compact(['elementData', 'textRender']));
	}
}
