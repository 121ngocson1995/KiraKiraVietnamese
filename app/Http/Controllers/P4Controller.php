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
		$elementData = P4SentenceRecognize::where('lesson_id', '=', $lesson_id)->get()->toArray();

		$soundArr = array();
		foreach ($elementData as $element) {
				$soundArr[] = [
				"id" => $element['id'],
				"audio" => $element['audio']
			];
		}
		shuffle($soundArr);
		return view("activities.P4", compact(['elementData', 'soundArr']));
	}  
}
