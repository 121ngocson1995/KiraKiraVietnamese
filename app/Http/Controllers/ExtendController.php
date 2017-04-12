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

		$slide_imgArr = array();
		$slide_nameArr = array();

		if ($cnt != 0)
		{
			for ($i=0; $i<$cnt; $i++){
				$contentArr[$i] = explode( "|", $elementData[$i]->content);
				$thumbArr[$i] = explode( "|", $elementData[$i]->thumbnail);
				if ($elementData[$i]->type == 0) {
					$slide_imgArr[(string)$i] = explode( "|", $elementData[0]->slideshow_images);
					$slide_nameArr[(string)$i] = explode( "|", $elementData[0]->slideshow_caption);
				}
			}
			foreach ($elementData as $key)
			{
				$titleArr[] = $key->title;
			} 
			$typeEn = ['Images', 'Song', 'Poem','Idioms','Riddle', 'Play'];
			$typeVn = ['Hình ảnh đất nước - con người Việt Nam', 'Bài hát dành cho em', 'Em đọc thơ', 'Thành ngữ -Tục ngữ - Ca dao', 'Câu đố', 'Cùng chơi các ban ơi!'];

			return view("activities.Extendv2", compact(['elementData', 'contentArr','thumbArr', 'slide_imgArr', 'slide_nameArr', 'typeEn', 'typeVn','cnt']));

		} else {
			return view("activities.Extendv2", compact(['elementData', 'contentArr','titleArr', 'cnt'])); 
		}
	}
}



