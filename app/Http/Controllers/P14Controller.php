<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P14Element;

class P14Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
    	$elementData = P14Element::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);
    	$nounArr = array();
    	$clauseArr = array();

    	if ($cnt != 0){
    		for ($i=0; $i<$cnt; $i++){
    			$nounArr1[$i] = explode( "{", $elementData[$i]->sentence);
    		}

    		//dd($nounArr1);

    		return view("P14", compact(['elementData', 'dialogCnt'])); 
    	} else {
    		return view("P14", compact(['elementData', 'dialogCnt']));
    	}

    	
    	
    }
}
