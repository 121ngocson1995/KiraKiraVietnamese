<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P1WordMemorize;


class P1Controller extends Controller
{
	public function load()
	{
		// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P1WordMemorize::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		$firstLineNumber;

		if ($cnt != 0)
		{
			$firstLineNumber = $elementData[0]->lineNo;
			return view("activities.P1v3", compact(['elementData', 'firstLineNumber']));
		} else {
			return view("activities.P1v3", compact('elementData'));
		}
	}
	
}
