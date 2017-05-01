<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P9ConversationFillSentence;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P9Controller extends Controller
{
    /**
     * Create a new controller instance.
     *　新しいコントローラーのインスタンスを作成する。
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

		//　レッスンを取る。
        $lesson = LessonController::getLesson($lessonNo);
        if (count($lesson) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The lesson you\'ve chosen has yet been created.');
            return back();
        }
		$lesson_id = $lesson->id;

		// Load data from Database
        // データベースからデータを出す。
		$elementData = P9ConversationFillSentence::where('lesson_id', '=', $lesson_id)->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }
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

	public function edit(Request $request)
	{
        // dd($request->all()['update']['1'][0][0]['line']);
         // dd($request->all());
		$lesson = Lesson::find($request->all()['lessonID']);

		if ($request->has('update')) {
			foreach ($request->update as $id => $content) {
				foreach ($content as $dialogNo => $dialogContent) {
					foreach ($dialogContent as $lineNo => $lineContent) {
						$p9Element = P9ConversationFillSentence::where('id', '=', $id)->first();
						$p9Element->dialogNo = $dialogNo;
						$p9Element->lineNo = $lineNo;
						$line = str_replace("〇", '*', $lineContent['line']);
						$sumAnswer = count(explode('*',$line ))-1;
						$p9Element->line = $line;
						$answer = "";
						if($sumAnswer>0){
							foreach ($lineContent['answer'] as $answerContent ) {
								$answer = $answer.$answerContent.",";
							}
						}
						$answer = substr_replace($answer, "", -1);
						$p9Element->answer = $answer;
						$p9Element->save();
					}
				}

			}
		}

		if ($request->has('insert')) {

			foreach ($request->insert as $dialogNo => $dialogNoContent) {
				foreach ($dialogNoContent as $lineNo => $lineNoContent) {
					$p9New = new P9ConversationFillSentence;
					$p9New->dialogNo = $dialogNo;
					$p9New->lineNo = $lineNo;
					$line = str_replace("〇", '*', $lineNoContent['line']);
					$sumAnswer = count(explode('*',$line ))-1;
					$p9New->line = $line;
					$answer = "";
					if($sumAnswer>0){
						foreach ($lineNoContent['answer'] as $answerContent ) {
							$answer = $answer.$answerContent.",";
						}
					}
					$answer = substr_replace($answer, "", -1);
					$p9New->answer = $answer;
					$p9New->lesson_id = $request->all()['lessonID'];
					$p9New->save();
				}

			}

		}

		if ($request->has('sumDeleteRow')) {
			$sumDeleteRow = $request->all()['sumDeleteRow'];
			for ($i=0; $i <= $sumDeleteRow; $i++) { 
				if ($request->has('delete'.$i)) {
					$deleteId = $request->all()['delete'.$i];
					$p9delete = P9ConversationFillSentence::where('id', '=', $deleteId)->first()->delete();
				}

			}
		}

		if ($request->has('sumDeleteDia')) {
			$sumDeleteRow = $request->all()['sumDeleteDia'];
			for ($i=0; $i <= $sumDeleteRow; $i++) { 
				if ($request->has('deleteDia'.$i)) {
					$deleteId = $request->all()['deleteDia'.$i];
					$p9delete = P9ConversationFillSentence::where('lesson_id', '=', $request->lessonID)->where('dialogNo', '=', $deleteId)->delete();
				}

			}
		}

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

		return redirect("/listAct".$request->all()['lessonID']);
	}
}


