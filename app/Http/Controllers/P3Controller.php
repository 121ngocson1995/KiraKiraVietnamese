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
		dd($request);
		$lesson = Lesson::find($request->all()['lessonID']);
		$totalNew = $request->all()['sumOrigin'];
		for ($i=0; $i <= $totalNew ; $i++) { 
			if ($request->exists("sentenceId".$i)) {
				$p3Edit = P3SentenceMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["sentenceId".$i])->get();

				// $this->validate($request, [
				// 	"word".$i => 'string|max:10',
				// 	]);
				$p3Edit[0]->sentence = $request->all()['sentence'.$i];
				$p3Edit[0]->sentenceNo = $i;

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
		}

		$sumAdd = $request->all()['sumAdd'];
		for ($i=0; $i <= $sumAdd ; $i++) { 
			if ($request->exists("sentenceAdd".$i)) {
				$p3New = new P3SentenceMemorize;
				$p3New->sentenceNo = $totalNew + $i;
				$p3New->lesson_id = $request->all()['lessonID'];
				$sentence = $request->all()["sentenceAdd".$i];
					// $this->validate($request, [
					// 	"word".$i => 'string|max:10',
					// 	]);
				$p3New->sentence = $sentence;
				$t=time();
				$t=date("Y-m-d-H-i-s",$t);
				$destinationPath = "audio/P3/lesson".$lesson->lessonNo;

				$extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
				$fileName = $p3New->sentenceNo."-".$t.'.'.$extension;

				Input::file("audioAdd".$i)->move($destinationPath, $fileName);
				$newName = "audio/P3/lesson".$lesson->lessonNo."/".$p3New->sentenceNo."-".$t.'.'.$extension;

				$p3New->audio = $newName;
				$p3New->save();
			}
		}

		$sumDelete = $request->all()['sumDelete'];
		for ($i=0; $i <= $sumDelete ; $i++) { 
			if ($request->exists("delete".$i)) {
				$p3Edit = P3SentenceMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
			}
		}
		return Redirect("/listAct".$request->all()['lessonID']);
	}
}
