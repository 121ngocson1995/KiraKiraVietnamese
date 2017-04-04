<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P7ConversationMemorize;

class P7Controller extends Controller
{
	public function load()
	{
			// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

    		// Lấy dữ liệu từ db
		$elementData = P7ConversationMemorize::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
		$cnt = count($elementData);
		$dialogCnt = array();
		$contentArr = array();
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
		$audioArr = array();
		for ($i=0; $i<count($dialogCnt); $i++){
			
			for ($j=0; $j < count($elementData) ; $j++) { 
				if ($elementData[$j]['dialogNo'] == $dialogCnt[$i]) {
					$lineParts = explode('|', $elementData[$j]['dialogue']);
					array_push($contentArr, $lineParts);
				}
			}
			array_push($audioArr, $elementData[$i]['audio']);
		}
	
		return view("activities.P7v2", compact(['elementData', 'contentArr', 'audioArr', 'dialogCnt']));
	}  
}
