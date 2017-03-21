<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P6Element;

class P6Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P6Element::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);

		$all = [];

		foreach ($elementData as $elementValue) {
			$newElem = (object) array(
				"dialogNo"  => $elementValue->dialogNo,
				"dialog"    => $elementValue->dialog,
				"answers"   => [
				"correctAnswer" => [
				"content"   => $elementValue->correctAnswer,
				"chosen"    => false
				],
				"wrongAnswer1" => [
				"content"   => $elementValue->wrongAnswer1,
				"chosen"    => false
				],
				"wrongAnswer2" => [
				"content"   => $elementValue->wrongAnswer2,
				"chosen"    => false
				]
				],
				"answerOrder" => [
				"correctAnswer",
				"wrongAnswer1",
				"wrongAnswer2"
				]
				);

			shuffle($newElem->answerOrder);

			$all[] = $newElem;
		}

		$elementData = $all;

		return view("activities.P6", compact(['elementData', 'cnt']));
	}
}
