<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P8Element;

class P8Controller extends Controller
{	
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P8Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
        $dialogCnt = array();
        $answerArrs = array();
        
        if ($cnt != 0){
            for ($i=0; $i<$cnt; $i++){
                $dup = false;
                for ($j=0; $j < count($dialogCnt) ; $j++) { 
                    if($elementData[$i]->dialogNo == $dialogCnt[$j]){
                        $dup = true;
                    }
                }
                if ($dup == false) {
                    array_push($dialogCnt, $elementData[$i]->dialogNo);
                }

                $elementData[$i]->answer = explode(',', $elementData[$i]->answer);
            }
            return view("P8", compact(['elementData', 'dialogCnt'])); 
        } else {
            return view("P8", compact(['elementData', 'dialogCnt']));
        }
    }


}
