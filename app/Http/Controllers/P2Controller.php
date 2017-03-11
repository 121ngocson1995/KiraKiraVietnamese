<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P2Element;

class P2Controller extends Controller
{
	public function load()
	{
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P2Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		$lastIndex = $elementData[$cnt-1]->correctOrder;
        $elementData = $elementData->shuffle();

		return view("P2", compact(['elementData', 'lastIndex']));
	}
}
