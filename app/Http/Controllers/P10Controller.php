<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P10Element;


class P10Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P10Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);

		$initOrder = [];
		foreach ($elementData as $key) {
			$initOrder[] = $key->correctOrder;
		}

		$currentOrder;

		do {
			$elementData = $elementData->shuffle();

			$currentOrder = array();
			foreach ($elementData as $key) {
				$currentOrder[] = $key->correctOrder;
			}
		} while ( $currentOrder === $initOrder );

		return view("P10", compact('elementData'));
	}
}
