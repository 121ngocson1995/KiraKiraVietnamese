<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LanguageCulture;

class ExtendController extends Controller
{
	public function load()
	{
    	// dummy course và lesson
		$course_id= 1;
		$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = LanguageCulture::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		if ($cnt != 0)
		{
			for ($i=0; $i<$cnt; $i++){
				$contentArr[$i] = explode( "|", $elementData[$i]->content);
				$thumbArr[$i] = explode( "|", $elementData[$i]->thumbnail);
				$slide_imgArr = explode( "|", $elementData[0]->slideshow_images);
				$slide_nameArr = explode( "|", $elementData[0]->slideshow_caption);
				$img = $elementData[0]->thumbnail;
			}
			foreach ($elementData as $key) 
			{
				$titleArr[] = $key->title;
			} 
			$typeArr = ['Image', 'Song', 'Poem','Idioms','Riddle', 'Play'];

		return view("activities.Extend", compact(['elementData', 'contentArr','thumbArr', 'titleArr','slide_imgArr', 'slide_nameArr','typeArr', 'cnt'])); 

	} else {
		return view("activities.Extend", compact(['elementData', 'contentArr','titleArr', 'typeArr', 'cnt'])); 
	}
}
}



