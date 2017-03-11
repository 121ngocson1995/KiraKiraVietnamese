<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3Element;

class P3Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P3Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		return view("P3", compact(['elementData', 'cnt']));
	}
}
