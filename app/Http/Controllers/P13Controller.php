<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P13Element;

class P13Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    	// Lấy dữ liệu từ db
    	$elementData = P13Element::where('lesson_id', '=', $lesson_id)->get();

    	foreach ($elementData as $value) 
    	{
    		$noteArr = explode("|", $value->note);
    	} 

    	return view("P13", compact(['elementData', 'noteArr'])); 
    }
}
