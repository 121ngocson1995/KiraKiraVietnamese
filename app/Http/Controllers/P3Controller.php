<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P3SentenceMemorize;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P3Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P3SentenceMemorize::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);
		return view("activities.P3v2", compact(['elementData', 'cnt']));
	}

	public function edit(Request $request) {

		$lesson = Lesson::find($request->all()['lessonID']);
		$totalOld = $request->all()['sumOrigin'];
		$totalNew = $request->all()['sumLine'];

		if($totalNew >= $totalOld){
			$validate = array();
			for ($i=1; $i <= $totalOld ; $i++) { 
				$p3Edit = P3SentenceMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $i)->get();
				
				// $this->validate($request, [
				// 	"sentence".$i => 'string|max:10',
				// 	]);

				$p3Edit[0]->sentence = $request->all()['sentence'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P3/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p3Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P3/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P3/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p3Edit[0]->audio = $newName;
				}else{
					$p3Edit[0]->audio = "";
				}
				$p3Edit[0]->save();
			}

			if ($totalNew > $totalOld) {
				for ($i=$totalOld+1; $i <= $totalNew ; $i++) { 
					$p3New = new P1WordMemorize;
					$p3New->sentenceNo = $i;
					$p3New->lesson_id = $request->all()['lessonID'];
					$sentence = $request->all()["sentence".$i];
					

					// $this->validate($request, [
					// 	"sentence".$i => 'string|max:10',
					// 	]);
					$p3New->word = $word;

					if($request->exists("audio".$i)){

						$t=time();
						$t=date("Y-m-d-H-i-s",$t);
						$destinationPath = "audio/P3/lesson".$lesson->lessonNo;

						$extension = Input::file("audio".$i)->getClientOriginalExtension();
						$fileName = $i."-".$t.'.'.$extension;

						Input::file("audio".$i)->move($destinationPath, $fileName);
						$newName = "audio/P3/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

						$p3New->audio = $newName;
					}else{
						$p3New->audio = "";
					}
					$p3New->save();
				}
			}
		}else if($totalNew < $totalOld){
			for ($i=1; $i <= $totalNew ; $i++) { 
				$p3Edit = P3SentenceMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $i)->get();
				
				// $this->validate($request, [
				// 	"sentence".$i => 'string|max:10',
				// 	]);

				$p3Edit[0]->word = $request->all()['sentence'.$i];

				if($request->exists("audioPath".$i)){
					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$oldName = $request->all()["audioPath".$i];
					$newName = "audio/P3/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
					rename($oldName, $newName);
					$p1Edit[0]->audio = $newName;
				}else if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					$destinationPath = "audio/P3/lesson".$lesson->lessonNo;

					$extension = Input::file("audio".$i)->getClientOriginalExtension();
					$fileName = $i."-".$t.'.'.$extension;

					Input::file("audio".$i)->move($destinationPath, $fileName);
					$newName = "audio/P3/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$p3Edit[0]->audio = $newName;
				}else{
					$p3Edit[0]->audio = "";
				}
				$p3Edit[0]->save();
			}

			for ($i=$totalNew+1; $i <= $totalOld ; $i++) { 
				$p3Edit = P3SentenceMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $i)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['lessonID']);
	}
}
