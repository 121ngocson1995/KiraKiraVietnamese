<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3SentenceMemorize;

class P3Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P3SentenceMemorize::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		return view("activities.P3v2", compact(['elementData', 'cnt']));
	}
}
