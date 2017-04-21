<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P13Text;

class P13Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'load']);
    }
    
    /**
     * Load data from database.
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
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
    		$noteArrEn = explode("|", $value->note_translate);
    	} 

    	return view("activities.P13", compact(['elementData', 'noteArr', 'noteArrEn'])); 
    }
}
