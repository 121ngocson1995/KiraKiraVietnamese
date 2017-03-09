<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P4Element;

class P4Controller extends Controller
{
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P4Element::where('lesson_id', '=', $lesson_id)->get()->toArray();
		shuffle($elementData);
		return view("P4", compact('elementData'));
	}  
}
