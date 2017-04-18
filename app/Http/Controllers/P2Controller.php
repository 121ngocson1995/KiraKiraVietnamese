<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P2WordRecognize;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P2Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
    	// get lesson
    	$lesson = LessonController::getLesson($lessonNo);

		// get P2
		$elementData = P2WordRecognize::where('lesson_id', '=', $lesson->id)->get();

		$textRender = array();
		foreach ($elementData as $element) {
			$textRender[] = [
				"id" => $element->id,
				"word" => $element->word
			];
		}

		shuffle($textRender);
		$elementData = $elementData->shuffle();

		return view("activities.P2v2", compact(['elementData', 'textRender']));
	}

	public function edit(Request $request) {

		$lesson = Lesson::find($request->all()['situaID']);
		$totalOld = $request->all()['sumOrigin'];
		$totalNew = $request->all()['sumLine'];

		if($totalNew >= $totalOld){
			$validate = array();
			for ($i=1; $i <= $totalOld ; $i++) { 
				$p2Edit = P2WordRecognize::where('lesson_id', '=', $request->all()['situaID'])->where('id', '=', $i)->get();
				
				$this->validate($request, [
					"word".$i => 'string|max:10',
					]);

				$p2Edit[0]->word = $request->all()['word'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p2Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P2/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p2Edit[0]->audio = $newName;
				}else{
					$p2Edit[0]->audio = "";
				}
				$p2Edit[0]->save();
			}

			if ($totalNew > $totalOld) {
				for ($i=$totalOld+1; $i <= $totalNew ; $i++) { 
					$p2New = new P2WordRecognize;
					$p2New->situationNo = $i;
					$p2New->lesson_id = $request->all()['situaID'];
					$word = $request->all()["word".$i];
					

					$this->validate($request, [
						"word".$i => 'string|max:10',
						]);
					$p2New->word = $word;

					if($request->exists("audioPath".$i)){
						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$oldName = $request->all()["audioPath".$i];
						$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
						rename($oldName, $newName);
						$SituaEdit[0]->audio = $newName;
					}else if($request->exists("audio".$i)){

						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$destinationPath = "audio/P2/lesson".$lesson->lessonNo;

						$extension = Input::file("audio".$i)->getClientOriginalExtension();
						$fileName = $i."-".$t.'.'.$extension;

						Input::file("audio".$i)->move($destinationPath, $fileName);
						$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

						$p2Edit[0]->audio = $newName;
					}else{
						$p2Edit[0]->audio = "";
					}
					$p2Edit[0]->save();
				}
			}
		}else if($totalNew < $totalOld){
			for ($i=1; $i <= $totalNew ; $i++) { 
				$p2Edit = P2WordRecognize::where('lesson_id', '=', $request->all()['situaID'])->where('id', '=', $i)->get();
				
				$this->validate($request, [
					"word".$i => 'string|max:10',
					]);

				$p2Edit[0]->word = $request->all()['word'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p2Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P2/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p2Edit[0]->audio = $newName;
				}else{
					$p2Edit[0]->audio = "";
				}
				$p2Edit[0]->save();
			}

			for ($i=$totalNew+1; $i <= $totalOld ; $i++) { 
				$p2Edit = P2WordRecognize::where('lesson_id', '=', $request->all()['situaID'])->where('id', '=', $i)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['situaID']);
	}
}
