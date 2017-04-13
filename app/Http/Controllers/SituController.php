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
    			$dialogArrEn[$i] = explode( "|", $elementData[$i]->dialog_translate);
                $audioArr[$i] =  $elementData[$i]->audio;
    		}

    		return view("activities.Situationv2", compact(['elementData', 'audioArr', 'dialogArr', 'dialogArrEn', 'cnt'])); 
    		
    	} else {
    		return view("activities.Situationv2", compact(['elementData']));
    	}
    }
}
