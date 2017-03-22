<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P10SentenceReorder;

class P10Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$data = P10SentenceReorder::where('lesson_id', '=', $lesson_id)->orderBy('sentenceNo', 'asc')->get();

		$curSentenceNo = 0;

		/* restructure elementData */
		$elementData = array();
		$curElement = array();
		foreach ($data as $dataValue) {
			if ($dataValue->sentenceNo != $curSentenceNo) {
				if ($curSentenceNo != 0) {
					$elementData[] = $curElement;
					$curElement = array();
				}
				$curSentenceNo = $dataValue->sentenceNo;
			}
			
			$curElement[] = $dataValue;
		}
		$elementData[] = $curElement;

		/* shuffle words in elementData */
		for ($i=0; $i < count($elementData); $i++) { 
			$initOrder = [];
			foreach ($elementData[$i] as $elementValue) {
				$initOrder[] = $elementValue->correctOrder;
			}

			$currentOrder;

			do {
				shuffle($elementData[$i]);

				$currentOrder = array();
				foreach ($elementData[$i] as $elementValue) {
					$currentOrder[] = $elementValue->correctOrder;
				}
			} while ( $currentOrder === $initOrder );
		}

		return view("activities.P10", compact('elementData'));
	}
}
