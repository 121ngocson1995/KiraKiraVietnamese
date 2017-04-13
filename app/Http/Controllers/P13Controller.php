<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P13Text;

class P13Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
        $lesson_id = $lesson->id;

    	// Lấy dữ liệu từ db
    	$elementData = P13Text::where('lesson_id', '=', $lesson_id)->get();

    	foreach ($elementData as $value) 
    	{
    		$noteArr = explode("|", $value->note);
    	} 

    	return view("activities.P13", compact(['elementData', 'noteArr'])); 
    }
}
