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
				$img = $elementData[0]->thumbnail;
			}
			foreach ($elementData as $key) 
			{
				$titleArr[] = $key->title;
			} 
			$typeArr = ['Image', 'Song', 'Poem','Idioms','Riddle', 'Play'];
			$imgArr0 = explode( "|", $img);
			// chưa có DB nên test thử
			$imgNameArr = ['Bản đồ Việt Nam', 'Quốc kỳ', 'Tháp Rùa', 'Vịnh Hạ Long', 'Trường mẫu giáo', 'Cánh đồng lúa'];
			$imgArr = ['exten/img/bando.jpg', 'exten/img/quocki.png', 'exten/img/thaprua.jpg', 'exten/img/halong.jpg','exten/img/nhatre.jpg','exten/img/donglua.jpg']; 
		return view("activities.Extend", compact(['elementData', 'contentArr','thumbArr', 'titleArr','imgArr', 'imgNameArr','typeArr', 'cnt'])); 

	} else {
		return view("activities.Extend", compact(['elementData', 'contentArr','titleArr', 'typeArr', 'cnt'])); 
	}
}
}



