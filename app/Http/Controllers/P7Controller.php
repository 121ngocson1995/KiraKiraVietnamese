<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P7Element;

class P7Controller extends Controller
{
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P7Element::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
		$cnt = count($elementData);
		$dialogCnt = array();
		$contentArr = array();
		$audioArr = array();
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
		}
		for ($i=0; $i<count($dialogCnt); $i++){
			$contentArr[$i] = array();
			$audioArr[$i] = array();
			for ($j=0; $j < count($elementData) ; $j++) { 
				if ($elementData[$j]['dialogNo'] == $dialogCnt[$i]) {
					$lineParts = explode('|', $elementData[$j]['line']);
					array_push($contentArr[$i], $lineParts);
					array_push($audioArr[$i], $elementData[$j]['audio']);
				}
			}
		}
		return view("P7", compact(['elementData', 'contentArr', 'audioArr', 'dialogCnt']));
	}  
}
