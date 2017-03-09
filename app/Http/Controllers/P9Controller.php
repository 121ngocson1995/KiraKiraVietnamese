<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P9Element;

class P9Controller extends Controller
{
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P9Element::where('lesson_id', '=', $lesson_id)->get();
		$dialogCnt = array();
		$cnt = count($elementData);
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
			return view("P9", compact(['elementData', 'lessons', 'dialogCnt'])); 
		} else {
			return view("P9", compact(['elementData', 'lessons']));
		}
	}
}
