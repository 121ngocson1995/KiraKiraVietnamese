<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extension;

class ExtendController extends Controller
{
	public function load()
	{
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = Extension::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		if ($cnt != 0)
		{
			for ($i=0; $i<$cnt; $i++){
				$contentArr[$i] = explode( "|", $elementData[$i]->content);
				$thumbArr[$i] = explode( "|", $elementData[$i]->thumbnail);
			}
			foreach ($elementData as $key) 
			{
				$titleArr[] = $key->title;
			} 
			$typeArr = ['Image', 'Song', 'Poem','Riddle', 'Idioms', 'Play'];

		return view("activities.Extend", compact(['elementData', 'contentArr','thumbArr', 'titleArr', 'typeArr', 'cnt'])); 

	} else {
		return view("activities.Extend", compact(['elementData', 'contentArr','titleArr', 'typeArr', 'cnt'])); 
	}
}
}



