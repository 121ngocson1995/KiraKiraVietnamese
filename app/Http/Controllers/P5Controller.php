<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P5Element;

class P5Controller extends Controller
{
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P5Element::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
		$cnt = count($elementData);
		for ($i=0; $i<$cnt; $i++){
			$contentArr[$i] = explode( "|", $elementData[$i]->dialog);
		}
		for ($i=0; $i<$cnt; $i++){
			$audioArr[$i] = $elementData[$i]->audio;
		}
		return view("P5", compact(['dummy', 'contentArr', 'audioArr', 'cnt']));
	}  
}
