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

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function load(Request $request, $lessonNo){
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

	public function edit(Request $request) {
		$lesson = Lesson::find($request->all()['situaID']);
		$totalOld = $request->all()['sumOrigin'];
		$totalNew = $request->all()['sumLine'];

		if($totalNew >= $totalOld){
			$validate = array();
			for ($i=1; $i <= $totalOld ; $i++) { 
				$SituaEdit = Situation::where('lesson_id', '=', $request->all()['situaID'])->where('situationNo', '=', $i)->get();
				$dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
				$dialog_validate = explode("|",$dialog);

				Validator::make($dialog_validate, [
					'dialog_validate.0' => 'string|max:80'
					], [
					'max:80' => 'dialog sentence has maximum 80 character'
					]);
				$dialog_translate = str_replace("\n", "|", $request->all()["dialogTrans".$i]);
				$dialog_translate_validate = explode("|",$dialog_translate);
				
				Validator::make($dialog_translate_validate, [
					'dialog_translate_validate[0]' => 'string|max:80'
					], [
					'max:80' => 'dialog sentence has maximum 80 character'
					]);
				dd($dialog_translate_validate);
				$SituaEdit[0]->dialog = $dialog;
				$SituaEdit[0]->dialog_translate =  $dialog_translate;
				if($request->exists("imgPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["imgPath".$i];
					$newName = "Situation_img/S".$i."-".$t.".".substr($oldName,-3,3);

					rename($oldName, $newName);
					$SituaEdit[0]->thumbnail = $newName;
				}elseif($request->exists("image".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = 'Situation_img'; 
					$extension = Input::file("image".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;
					Input::file("image".$i)->move($destinationPath, $fileName);
					$newName = "Situation_img/S".$i."-".$t.".".$extension;
					$SituaEdit[0]->thumbnail = $newName;
				}else{
					$SituaEdit[0]->thumbnail = "";
				}

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$SituaEdit[0]->audio = $newName;
				}elseif($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/Situation/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.'.'.$extension;

					$SituaEdit[0]->audio = $newName;
				}else{
					$SituaEdit[0]->audio = "";
				}
				$SituaEdit[0]->save();
			}

			if ($totalNew > $totalOld) {
				for ($i=$totalOld+1; $i <= $totalNew ; $i++) { 
					$SituaNew = new Situation;
					$SituaNew->situationNo = $i;
					$SituaNew->lesson_id = $request->all()['situaID'];
					$dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
					$dialog_translate = str_replace("\n", "|", $request->all()["dialogTrans".$i]);
					$SituaNew->dialog = $dialog;
					$SituaNew->dialog_translate = $dialog_translate;

					if($request->exists("imgPath".$i)){
						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$oldName = $request->all()["imgPath".$i];
						$newName = "Situation_img/S".$i."-".$t.".".substr($oldName,-3,3);

						rename($oldName, $newName);
						$SituaNew->thumbnail = $newName;
					}elseif($request->exists("image".$i)){
						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$destinationPath = 'Situation_img'; 
						$extension = Input::file("image".$i)->getClientOriginalExtension();
						$fileName = "S".$i."-".$t.'.'.$extension;
						Input::file("image".$i)->move($destinationPath, $fileName);
						$newName = "Situation_img/S".$i."-".$t.".".$extension;
						$SituaNew->thumbnail = $newName;
					}else{
						$SituaNew->thumbnail = "";
					}

					if($request->exists("audioPath".$i)){
						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$oldName = $request->all()["audioPath".$i];
						$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.".mp3";
						rename($oldName, $newName);
						$SituaNew->audio = $newName;
					}elseif($request->exists("audio".$i)){

						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$destinationPath = "audio/Situation/lesson".$lesson->lessonNo;

						$extension = Input::file("audio".$i)->getClientOriginalExtension();
						$fileName = "S".$i."-".$t.'.'.$extension;

						Input::file("audio".$i)->move($destinationPath, $fileName);
						$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.'.'.$extension;

						$SituaNew->audio = $newName;
					}else{
						$SituaNew->audio = "";
					}
					$SituaNew->save();

				}
			}
		}elseif($totalNew < $totalOld){
			for ($i=1; $i <= $totalNew ; $i++) { 
				$SituaEdit = Situation::where('lesson_id', '=', $request->all()['situaID'])->where('situationNo', '=', $i)->get();
				$dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
				$dialog_translate = str_replace("\n", "|", $request->all()["dialogTrans".$i]);
				$SituaEdit[0]->dialog = $dialog;
				$SituaEdit[0]->dialog_translate =  $dialog_translate;
				if($request->exists("imgPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["imgPath".$i];
					$newName = "Situation_img/S".$i."-".$t.".".substr($oldName,-3,3);

					rename($oldName, $newName);
					$SituaEdit[0]->thumbnail = $newName;
				}elseif($request->exists("image".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = 'Situation_img'; 
					$extension = Input::file("image".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;
					Input::file("image".$i)->move($destinationPath, $fileName);
					$newName = "Situation_img/S".$i."-".$t.".".$extension;
					$SituaEdit[0]->thumbnail = $newName;
				}else{
					$SituaEdit[0]->thumbnail = "";
				}

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$SituaEdit[0]->audio = $newName;
				}elseif($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/Situation/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = "S".$i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.'.'.$extension;

					$SituaEdit[0]->audio = $newName;
				}else{
					$SituaEdit[0]->audio = "";
				}
				$SituaEdit[0]->save();
			}

			for ($i=$totalNew+1; $i <= $totalOld ; $i++) { 
				$SituaEdit = Situation::where('lesson_id', '=', $request->all()['situaID'])->where('situationNo', '=', $i)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['situaID']);
	}
}
