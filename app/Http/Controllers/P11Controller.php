<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P11Element;

class P11Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P11Element::where('lesson_id', '=', $lesson_id)->orderBy('correctOrder', 'asc')->get();
    	$initOrder = [];
    	$correctAnswer = [];
    	
    	foreach ($elementData as $key) {
    		$initOrder[] = $key->correctOrder;
    	}
    	foreach ($elementData as $key) {
    		$correctAnswer[] = $key->sentence;
    	}

    	$currentOrder;
    	do {
            $elementData = $elementData->shuffle();
            // dd($elementData);
    		$currentOrder = array();
    		foreach ($elementData as $key) {
    			$currentOrder[] = $key->correctOrder;
    		}
    	} while ( $currentOrder === $initOrder );

    	return view("P11", compact(['elementData', 'correctAnswer']));
    }
}
