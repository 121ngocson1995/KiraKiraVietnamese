<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P14SentencePattern;

class P14Controller extends Controller
{
    public function load()
    {
        // dummy course và lesson
        $course_id= 1;
        $lesson_id= 1;

        // Lấy dữ liệu từ db
        $elementData = P14SentencePattern::where('lesson_id', '=', $lesson_id)->get();
        $cnt = count($elementData);
        $nounArr = array();
        $clauseArr = array();

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

            return view("activities.P14", compact(['elementData', 'open', 'nounArr', 'close', 'cnt'])); 
        } else {
            return view("activities.P14", compact('elementData'));
        }
    }
}