<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Situation;
use App\Lesson;
use Redirect;
use App\LessonNote;
use Illuminate\Support\Facades\Validator;

class SituController extends Controller{

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
	public function load(Request $request, $lessonNo){
    	// get lesson
    	//　レッスンを取る。
		$lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Load data from Database
        // データベースからデータを出す。
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
		if ($cnt != 0){
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

		for ($i=1; $i <= $totalNew ; $i++) { 
			if ($request->exists("situationId".$i)) {
				$situEdit = Situation::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["situationId".$i])->get();
				
				$dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
				$dialog_validate = explode("|",$dialog);

				$dialog_translate = str_replace("\r\n", "|", $request->all()["dialogTrans".$i]);
				$dialogTrans_validate = explode("|",$dialog_translate);

				// $validate['dialog'] = $dialog_validate;
				// $validate['dialogTrans'] = $dialogTrans_validate;
				
				// $messages = [
				// 'max'    => 'The :attribute has maximum :max characters per sentence.',
				// ];

				// Validator::make($validate, [
				// 	'dialog.*' => 'string|max:80',
				// 	'dialogTrans.*' => 'string|max:80',
				// 	], $messages)->validate();
				// dd();
				$situEdit[0]->dialog = $dialog;
				$situEdit[0]->dialog_translate =  $dialog_translate;
				if($request->exists("imgPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["imgPath".$i];
					$newName = "Situation_img/S".$i."-".$t.".".substr($oldName,-3,3);

					rename($oldName, $newName);
					$situEdit[0]->thumbnail = $newName;
				}else if($request->exists("image".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = 'Situation_img'; 
					$extension = Input::file("image".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;
					Input::file("image".$i)->move($destinationPath, $fileName);
					$newName = "Situation_img/S".$i."-".$t.".".$extension;
					$situEdit[0]->thumbnail = $newName;
				}else{
					$situEdit[0]->thumbnail = "";
				}

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$situEdit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/Situation/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.'.'.$extension;

					$situEdit[0]->audio = $newName;
				}else{
					$situEdit[0]->audio = "";
				}
				$situEdit[0]->save();
			}

			$sumAdd = $request->all()['sumAdd'];
			for ($i=1; $i <= $sumAdd ; $i++) { 
				if ($request->exists("dialogAdd".$i)) {

					$situNew = new Situation;
					$situNew->situationNo = $totalNew - 1 + $i;
					$situNew->lesson_id = $request->all()['lessonID'];

					$dialog = str_replace("\n", "|", $request->all()["dialogAdd".$i]);
					$dialog_validate = explode("|",$dialog);

					$dialog_translate = str_replace("\r\n", "|", $request->all()["dialogTransAdd".$i]);
					$dialogTrans_validate = explode("|",$dialog_translate);

					// $validate['dialog'] = $dialog_validate;
					// $validate['dialogTrans'] = $dialogTrans_validate;

					// $messages = [
					// 'max'    => 'The :attribute has maximum :max characters per sentence.',
					// ];

					// Validator::make($validate, [
					// 	'dialog.*' => 'string|max:80',
					// 	'dialogTrans.*' => 'string|max:80',
					// 	], $messages)->validate();
					$situNew->dialog = $dialog;
					$situNew->dialog_translate =  $dialog_translate;

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = 'Situation_img'; 
					$extension = Input::file("imageAdd".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;
					Input::file("imageAdd".$i)->move($destinationPath, $fileName);
					$newName = "Situation_img/S".$i."-".$t.".".$extension;
					$situNew->thumbnail = $newName;

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/Situation/lesson".$lesson->lessonNo;

					$extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
					$fileName = $situNew->situationNo."-".$t.'.'.$extension;

					Input::file("audioAdd".$i)->move($destinationPath, $fileName);
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/".$situNew->situationNo."-".$t.'.'.$extension;

					$situNew->audio = $newName;
					$situNew->save();
				}
			}

			$sumDelete = $request->all()['sumDelete'];
			for ($i=0; $i <= $sumDelete ; $i++) { 
				if ($request->exists("delete".$i)) {
					$situEdit = Situation::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
				}
			}
			return Redirect("/listAct".$request->all()['lessonID']);
		}
	}
}
