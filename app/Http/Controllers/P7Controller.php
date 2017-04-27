<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P7ConversationMemorize;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P7Controller extends Controller
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
    	$elementData = P7ConversationMemorize::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
    	$cnt = count($elementData);
    	$dialogCnt = array();
    	$contentArr = array();
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
    	}
    	$audioArr = array();
    	for ($i=0; $i<count($dialogCnt); $i++){

    		for ($j=0; $j < count($elementData) ; $j++) { 
    			if ($elementData[$j]['dialogNo'] == $dialogCnt[$i]) {
    				$lineParts = explode('|', $elementData[$j]['dialogue']);
    				array_push($contentArr, $lineParts);
    			}
    		}
    		array_push($audioArr, $elementData[$i]['audio']);
    	}

    	return view("activities.P7v2", compact(['elementData', 'contentArr', 'audioArr', 'dialogCnt']));
    }  


    /**
     * Update database based on user's input.
     *　ユーザーからの入力によって、データベースを更新する。
     *
     * @param Request $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request) {
    	$lesson = Lesson::find($request->all()['lessonID']);
    	$totalNew = $request->all()['sumOrigin'];
    	for ($i=0; $i < $totalNew ; $i++) { 
    		if ($request->exists("dialogId".$i)) {
    			$p7Edit = P7ConversationMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["dialogId".$i])->get();
    			$p7Edit_sumLine = $request->all()["dialog".$i];
    			$p7Edit_lines = array();
    			for ($j=0; $j < $p7Edit_sumLine; $j++) { 
    				array_push($p7Edit_lines, $request->all()["speaker-".$i."-".$j]."*".$request->all()["dialogue-".$i."-".$j]);
    			}
    			$dialogue ="";
    			for ($k=0; $k < count($p7Edit_lines) ; $k++) { 
    				$dialogue = $dialogue.$p7Edit_lines[$k]."|";
    			}
    			$dialogue = substr_replace($dialogue, "", -1);


    			$messages = [
    			'max'    => 'The :attribute has maximum :max characters per sentence.',
    			];

				// Validator::make($validate, [
				// 	'dialog.*' => 'string|max:80',
				// 	], $messages)->validate();
    			$p7Edit[0]->dialogue = $dialogue;
    			$p7Edit[0]->dialogNo = $i;

    			// if($request->exists("audioPath".$i)){
    			// 	$t=time();
    			// 	$t=date("Y-m-d-H-i-s",$t);
    			// 	$oldName = $request->all()["audioPath".$i];
    			// 	$newName = "audio/P7/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
    			// 	rename($oldName, $newName);
    			// 	$p7Edit[0]->audio = $newName;
    			// }else 
                if($request->exists("audio".$i)){

    				$t=time();
    				$t=date("Y-m-d-H-i-s",$t);
					// $destinationPath = "audio/P7/lesson".$lesson->lessonNo;

					// $extension = Input::file("audio".$i)->getClientOriginalExtension();
					// $fileName = $i."-".$t.'.'.$extension;

					// Input::file("audio".$i)->move($destinationPath, $fileName);
					// $newName = "audio/P7/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

    				$data = $request["audio".$i];
    				$destinationPath = "audio/P7/lesson".$lesson->lessonNo;
    				$extension = $data->getClientOriginalExtension();
    				$fileName = $i."-".$t.'.'.$extension;
    				$newName = $data->storeAs($destinationPath, $fileName);

    				$p7Edit[0]->audio = $newName;
    			}else{
    				$p7Edit[0]->audio = "";
    			}
    			$p7Edit[0]->save();
    		}
    	}

    	$sumAdd = $request->all()['sumAdd'];

    	for ($i=1; $i <= $sumAdd ; $i++) { 
    		if ($request->exists("dialogAdd".$i) && $request->all()["dialogAdd".$i] != 0) {
    			$p7New = new P7ConversationMemorize;
    			$dialogNo = $totalNew - 1 + $i;

    			$p7New->dialogNo = $dialogNo;

    			$p7New->lesson_id = $request->all()['lessonID'];

    			$p7New_sumLine = $request->all()["dialogAdd".$i];
    			$p7New_lines = array();

    			for ($j=0; $j < $p7New_sumLine; $j++) { 
    				array_push($p7New_lines, $request->all()["speakerAdd-".$i."-".$j]."*".$request->all()["dialogueAdd-".$i."-".$j]);
    			}
    			$dialogue ="";
    			for ($k=0; $k < count($p7New_lines) ; $k++) { 
    				$dialogue = $dialogue.$p7New_lines[$k]."|";
    			}
    			$dialogue = substr_replace($dialogue, "", -1);
    			$messages = [
    			'max'    => 'The :attribute has maximum :max characters per sentence.',
    			];

				// Validator::make($validate, [
				// 	'dialog.*' => 'string|max:80',
				// 	], $messages)->validate();

    			$p7New->dialogue = $dialogue;
    			$t=time();
    			$t=date("Y-m-d-H-i-s",$t);

    			// $destinationPath = "audio/P7/lesson".$lesson->lessonNo;
    			// $extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
    			// $fileName = $p7New->dialogNo."-".$t.'.'.$extension;

    			// Input::file("audioAdd".$i)->move($destinationPath, $fileName);
    			// $newName = "audio/P7/lesson".$lesson->lessonNo."/".$p7New->dialogNo."-".$t.'.'.$extension;

    			$data = $request["audioAdd".$i];
    			$destinationPath = "audio/P7/lesson".$lesson->lessonNo;
    			$extension = $data->getClientOriginalExtension();
    			$fileName = $i."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);


    			$p7New->audio = $newName;
    			$p7New->save();
    		}
    	}
    	$sumDelete = $request->all()['sumDelete'];
    	for ($i=0; $i <= $sumDelete ; $i++) { 
    		if ($request->exists("delete".$i)) {
    			$p7Delete = P7ConversationMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
    		}
    	}



    	return redirect("/listAct".$request->all()['lessonID']);

    }
}
