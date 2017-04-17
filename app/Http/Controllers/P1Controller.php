<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P1WordMemorize;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P1Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
		// get lesson
		$lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P1WordMemorize::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		$firstLineNumber;

		if ($cnt != 0)
		{
			$firstLineNumber = $elementData[0]->lineNo;
			return view("activities.P1v3", compact(['elementData', 'firstLineNumber']));
		} else {
			return view("activities.P1v3", compact('elementData'));
		}
	}
	
	public function edit(Request $request) {

		$lesson = Lesson::find($request->all()['situaID']);
		$totalOld = $request->all()['sumOrigin'];
		$totalNew = $request->all()['sumLine'];

		if($totalNew >= $totalOld){
			$validate = array();
			for ($i=1; $i <= $totalOld ; $i++) { 
				$p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['situaID'])->where('wordNo', '=', $i)->get();
				
				$this->validate($request, [
					"word".$i => 'string|max:10',
					]);

				$p1Edit[0]->word = $request->all()['word'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p1Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P1/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p1Edit[0]->audio = $newName;
				}else{
					$p1Edit[0]->audio = "";
				}
				$p1Edit[0]->save();
			}

			if ($totalNew > $totalOld) {
				for ($i=$totalOld+1; $i <= $totalNew ; $i++) { 
					$p1New = new P1WordMemorize;
					$p1New->situationNo = $i;
					$p1New->lesson_id = $request->all()['situaID'];
					$word = $request->all()["word".$i];
					

					$this->validate($request, [
						"word".$i => 'string|max:10',
						]);
					$p1New->word = $word;

					if($request->exists("audioPath".$i)){
						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$oldName = $request->all()["audioPath".$i];
						$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
						rename($oldName, $newName);
						$SituaEdit[0]->audio = $newName;
					}else if($request->exists("audio".$i)){

						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$destinationPath = "audio/P1/lesson".$lesson->lessonNo;

						$extension = Input::file("audio".$i)->getClientOriginalExtension();
						$fileName = $i."-".$t.'.'.$extension;

						Input::file("audio".$i)->move($destinationPath, $fileName);
						$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

						$p1Edit[0]->audio = $newName;
					}else{
						$p1Edit[0]->audio = "";
					}
					$p1Edit[0]->save();
				}
			}
		}else if($totalNew < $totalOld){
			for ($i=1; $i <= $totalNew ; $i++) { 
				$p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['situaID'])->where('wordNo', '=', $i)->get();
				
				$this->validate($request, [
					"word".$i => 'string|max:10',
					]);

				$p1Edit[0]->word = $request->all()['word'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p1Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P1/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p1Edit[0]->audio = $newName;
				}else{
					$p1Edit[0]->audio = "";
				}
				$p1Edit[0]->save();
			}

			for ($i=$totalNew+1; $i <= $totalOld ; $i++) { 
				$p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['situaID'])->where('wordNo', '=', $i)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['situaID']);
	}
}
