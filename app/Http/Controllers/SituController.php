<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Situation;

class SituController extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
    	$elementData = Situation::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);
    	if ($cnt != 0)
    	{
    		for ($i=0; $i<$cnt; $i++){
    			$dialogArr[$i] = explode( "|", $elementData[$i]->dialog);
                $audioArr[$i] =  $elementData[$i]->audio;
    		}

    		return view("activities.Situation", compact(['elementData', 'audioArr', 'dialogArr', 'cnt'])); 
    		
    	} else {
    		return view("activities.Situation", compact(['elementData']));
    	}
    }
}
