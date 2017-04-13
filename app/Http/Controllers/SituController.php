<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Situation;
use App\LessonNote;

class SituController extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
        $noteData = LessonNote::where('lesson_id', '=', $lesson_id)->orderBy('noteNo', 'asc')->get();
        $cnt = count($noteData);
        if ($cnt != 0)
        {
            for ($i=0; $i<$cnt; $i++){
                $note_content[$i] = explode( "|", $noteData[$i]->content);
            }
        }

        $elementData = Situation::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);
    	if ($cnt != 0)
    	{
    		for ($i=0; $i<$cnt; $i++){
                $dialogArr[$i] = explode( "|", $elementData[$i]->dialog);
    			$dialogArrEn[$i] = explode( "|", $elementData[$i]->dialog_translate);
                $audioArr[$i] =  $elementData[$i]->audio;
    		}

    		return view("activities.Situationv2", compact(['elementData', 'note_content', 'audioArr', 'dialogArr', 'dialogArrEn'])); 
    		
    	} else {
    		return view("activities.Situationv2", compact(['elementData', 'note_content']));
    	}
    }
}
