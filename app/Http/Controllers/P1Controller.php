<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P1Element;


class P1Controller extends Controller
{
	public function load()
	{
		// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P1Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		$firstLineNumber;

		if ($cnt != 0)
		{
			$firstLineNumber = $elementData[0]->lineNo;
			return view("P1ani", compact(['elementData', 'firstLineNumber']));
		} else {
			return view("P1ani", compact('elementData'));
		}
	}
	
}
