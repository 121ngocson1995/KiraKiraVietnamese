<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P9ConversationFillSentence;

class P9Controller extends Controller
{
    /**
     * Create a new controller instance.
     *　新しいインスタントのコントローラーを作成する。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'load']);
    }
    
    /**
     * Load data from database.
     *　データベースからデータをロードする。
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
	public function load(Request $request, $lessonNo)
	{
		// get lesson
		//　レッスンを取る。
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Load data from Database
        // データベースからデータを出す。
		$elementData = P9ConversationFillSentence::where('lesson_id', '=', $lesson_id)->get();
		$dialogCnt = array();
		$cnt = count($elementData);
		if ($cnt != 0){
			for ($i=0; $i<$cnt; $i++){
				$dup = false;
				for ($j=0; $j < count($dialogCnt) ; $j++) { 
					if($elementData[$i]->dialogNo == $dialogCnt[$j]){
						$dup = true;
					}
				}
				if ($dup == false) {
					array_push($dialogCnt, $elementData[$i]->dialogNo);
				}

				$elementData[$i]->answer = explode(',', $elementData[$i]->answer);
			}
			return view("activities.P9", compact(['elementData', 'lessons', 'dialogCnt'])); 
		} else {
			return view("activities.P9", compact(['elementData', 'lessons']));
		}
	}
}
