<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P5DialogueMemorize;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P5Controller extends Controller
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
        if (count($lesson) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The lesson you\'ve chosen has yet been created.');
            return back();
        }
		$lesson_id = $lesson->id;

		// Load data from Database
        // データベースからデータを出す。
		$elementData = P5DialogueMemorize::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo', 'ASC')->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }
		$cnt = count($elementData);
		
		return view("activities.P5v2", compact(['elementData', 'contentArr', 'audioArr', 'cnt']));
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
				$p5Edit = P5DialogueMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["dialogId".$i])->get();

				$dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
				$dialog_validate = explode("|",$dialog);
				
				$messages = [
				'max'    => 'The :attribute has maximum :max characters per sentence.',
				];

				// Validator::make($validate, [
				// 	'dialog.*' => 'string|max:80',
				// 	], $messages)->validate();
				$p5Edit[0]->dialog = $dialog;
				$p5Edit[0]->dialogNo = $i;

				// if($request->exists("audioPath".$i)){
				// 	$t=time();
				// 	$t=date("Y-m-d-H-i-s",$t);
				// 	$oldName = $request->all()["audioPath".$i];
				// 	$newName = "audio/P5/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
				// 	rename($oldName, $newName);
				// 	$p5Edit[0]->audio = $newName;
				// }else 
				if($request->exists("audio".$i)){

					$t=time();
					$t=date("Y-m-d-H-i-s",$t);
					// $destinationPath = "audio/P5/lesson".$lesson->lessonNo;

					// $extension = Input::file("audio".$i)->getClientOriginalExtension();
					// $fileName = $i."-".$t.'.'.$extension;

					// Input::file("audio".$i)->move($destinationPath, $fileName);
					// $newName = "audio/P5/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					$data = $request["audio".$i];
    			$destinationPath = "audio/P5/lesson".$lesson->lessonNo;
    			$extension = $data->getClientOriginalExtension();
    			$fileName = $i."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);

					$p5Edit[0]->audio = $newName;
				}
				$p5Edit[0]->save();
			}
		}

		$sumAdd = $request->all()['sumAdd'];
		for ($i=0; $i <= $sumAdd ; $i++) { 
			if ($request->exists("dialogAdd".$i)) {
				
				$p5New = new P5DialogueMemorize;
				$p5New->dialogNo = $totalNew - 1 + $i;
				$p5New->lesson_id = $request->all()['lessonID'];

				$dialog = str_replace("\n", "|", $request->all()["dialogAdd".$i]);
				$dialog_validate = explode("|",$dialog);
				
				$messages = [
				'max'    => 'The :attribute has maximum :max characters per sentence.',
				];

				// Validator::make($validate, [
				// 	'dialog.*' => 'string|max:80',
				// 	], $messages)->validate();

				$p5New->dialog = $dialog;
				$t=time();
				$t=date("Y-m-d-H-i-s",$t);
				// $destinationPath = "audio/P5/lesson".$lesson->lessonNo;

				// $extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
				// $fileName = $p5New->sentenceNo."-".$t.'.'.$extension;

				// Input::file("audioAdd".$i)->move($destinationPath, $fileName);
				// $newName = "audio/P5/lesson".$lesson->lessonNo."/".$p5New->sentenceNo."-".$t.'.'.$extension;
				
				$data = $request["audioAdd".$i];
    			$destinationPath = "audio/P5/lesson".$lesson->lessonNo;
    			$extension = $data->extension();
    			$fileName = $i."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);

				$p5New->audio = $newName;
				$p5New->save();
			}
		}

		$sumDelete = $request->all()['sumDelete'];
		for ($i=0; $i <= $sumDelete ; $i++) { 
			if ($request->exists("delete".$i)) {
				$p5Edit = P5DialogueMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
			}
		}
		return Redirect("/listAct".$request->all()['lessonID']);
	}
}
