<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P12Element;

class P12Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    	// Lấy dữ liệu từ db
    	$elementData = P12Element::where('lesson_id', '=', $lesson_id)->get();
    	return view("P12", compact('elementData')); 
    }
}
