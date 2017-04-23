<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P8ConversationFillWord;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;
class P8Controller extends Controller
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
		// get lesson
        //　レッスンを取る。
        $lesson = LessonController::getLesson($lessonNo);
        $lesson_id = $lesson->id;

		// Load data from Database
        // データベースからデータを出す。
		$elementData = P8ConversationFillWord::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);

        $dialogCnt = array();
        $answerArrs = array();
        
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
            return view("activities.P8", compact(['elementData', 'dialogCnt'])); 
        } else {
            return view("activities.P8", compact(['elementData', 'dialogCnt']));
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
                       $p8Element = P8ConversationFillWord::where('id', '=', $id)->first();
                       $p8Element->dialogNo = $dialogNo;
                       $p8Element->lineNo = $lineNo;
                       $line = str_replace("〇", '*', $lineContent['line']);
                       $sumAnswer = count(explode('*',$line ))-1;
                       $p8Element->line = $line;
                       $answer = "";
                       if($sumAnswer>0){
                        foreach ($lineContent['answer'] as $answerContent ) {
                            $answer = $answer.$answerContent.",";
                        }
                    }
                    $answer = substr_replace($answer, "", -1);
                    $p8Element->answer = $answer;
                    $p8Element->save();
                }
            }
            
        }
    }

    if ($request->has('insert')) {

        foreach ($request->insert as $dialogNo => $dialogNoContent) {
            foreach ($dialogNoContent as $lineNo => $lineNoContent) {
                $p8New = new P8ConversationFillWord;
                $p8New->dialogNo = $dialogNo;
                $p8New->lineNo = $lineNo;
                $line = str_replace("〇", '*', $lineNoContent['line']);
                $sumAnswer = count(explode('*',$line ))-1;
                $p8New->line = $line;
                $answer = "";
                if($sumAnswer>0){
                    foreach ($lineNoContent['answer'] as $answerContent ) {
                        $answer = $answer.$answerContent.",";
                    }
                }
                $answer = substr_replace($answer, "", -1);
                $p8New->answer = $answer;
                $p8New->lesson_id = $request->all()['lessonID'];
                $p8New->save();
            }
            
        }
        
    }

    if ($request->has('sumDeleteRow')) {
        $sumDeleteRow = $request->all()['sumDeleteRow'];
        for ($i=0; $i <= $sumDeleteRow; $i++) { 
            if ($request->has('delete'.$i)) {
                $deleteId = $request->all()['delete'.$i];
                $p8delete = P8ConversationFillWord::where('id', '=', $deleteId)->first()->delete();
            }
            
        }
    }

    if ($request->has('sumDeleteDia')) {
        $sumDeleteRow = $request->all()['sumDeleteDia'];
        for ($i=0; $i <= $sumDeleteRow; $i++) { 
            if ($request->has('deleteDia'.$i)) {
                $deleteId = $request->all()['deleteDia'.$i];
                $p8delete = P8ConversationFillWord::where('dialogNo', '=', $deleteId)->delete();
            }
            
        }
    }
    return redirect("/listAct".$request->all()['lessonID']);
}
}
