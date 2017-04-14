<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P14SentencePattern;

class P14Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
        // get lesson
        $lesson = LessonController::getLesson($lessonNo);
        $lesson_id = $lesson->id;

        // Lấy dữ liệu từ db
        $elementData = P14SentencePattern::where('lesson_id', '=', $lesson_id)->get();
        $cnt = count($elementData);
        $nounArr = array();
        $clauseArr = array();
        $cntRow = $cnt/2;

        if ($cnt != 0){
            for ($i=0; $i<$cnt; $i++){
                $clauseArr[$i] = explode( "*", $elementData[$i]->sentence);
            }
            for ($i=0; $i<$cnt; $i++){
                $open[$i] = $clauseArr[$i][0];
                $nounArr[$i] = explode("|", $clauseArr[$i][1]);
                $close[$i] = $clauseArr[$i][2];
                // $nounArr[$i] = $clauseArr[$i][1];
            }
            // dd($open[10], $nounArr[10], $close[10]);
            return view("activities.P14", compact(['elementData', 'open', 'nounArr', 'close', 'cnt', 'cntRow'])); 
        } else {
            return view("activities.P14", compact('elementData'));
        }
    }
}