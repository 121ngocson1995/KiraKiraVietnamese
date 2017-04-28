<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P4SentenceRecognize;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Input;
use App\Lesson;
use Redirect;
use Illuminate\Support\Facades\Validator;

class P4Controller extends Controller
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
    	$elementData = P4SentenceRecognize::where('lesson_id', '=', $lesson_id)->get();

    	$textRender = array();
    	foreach ($elementData as $element) {
    		$textRender[] = [
    		"id" => $element->id,
    		"sentence" => $element->sentence
    		];
    	}

    	shuffle($textRender);
    	$elementData = $elementData->shuffle();

    	return view("activities.P4v2", compact(['elementData', 'textRender']));
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
    	for ($i=0; $i <= $totalNew ; $i++) { 
    		if ($request->exists("sentenceId".$i)) {

                $checkArray = array();
                $checkArray['sentence'.$i] = $request->all()['sentence'.$i];
                Validator::make($checkArray, [
                    'sentence'.$i => 'required|regex:/(^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹA-Za-z0-9 .?!]+$)+/|max:80',
                    ],
                    [
                    ])->validate();
    			$p4Edit = P4SentenceRecognize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["sentenceId".$i])->get();

				// $this->validate($request, [
				// 	"sentence".$i => 'string|max:10',
				// 	]);

    			$p4Edit[0]->sentence = $request->all()['sentence'.$i];

    			// if($request->exists("audioPath".$i)){
    			// 	$t=time();
    			// 	$t=date("Y-m-d-H-i-s",$t);
    			// 	$oldName = $request->all()["audioPath".$i];
    			// 	$newName = "audio/P4/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
    			// 	rename($oldName, $newName);
    			// 	$p4Edit[0]->audio = $newName;
    			// }else 
                if($request->exists("audio".$i)){

    				$t=time();
    				$t=date("Y-m-d-H-i-s",$t);
					// $destinationPath = "audio/P4/lesson".$lesson->lessonNo;

					// $extension = Input::file("audio".$i)->getClientOriginalExtension();
					// $fileName = $i."-".$t.'.'.$extension;

					// Input::file("audio".$i)->move($destinationPath, $fileName);
					// $newName = "audio/P4/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

    				$data = $request["audio".$i];
    				$destinationPath = "audio/P4/lesson".$lesson->lessonNo;
    				$extension = $data->getClientOriginalExtension();
    				$fileName = $i."-".$t.'.'.$extension;
    				$newName = $data->storeAs($destinationPath, $fileName);

    				$p4Edit[0]->audio = $newName;
    			}
    			$p4Edit[0]->save();
    		}
    	}

    	$sumAdd = $request->all()['sumAdd'];
    	for ($i=0; $i <= $sumAdd ; $i++) { 
    		if ($request->exists("sentenceAdd".$i)) {

                $checkArray = array();
                $checkArray['sentenceAdd'.$i] = $request->all()['sentenceAdd'.$i];
                Validator::make($checkArray, [
                    'sentenceAdd'.$i => 'required|regex:/(^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹA-Za-z0-9 .?!]+$)+/|max:80',
                    ],
                    [
                    ])->validate();
    			$p4New = new P4SentenceRecognize;
    			$p4New->lesson_id = $request->all()['lessonID'];
    			$sentence = $request->all()["sentenceAdd".$i];


					// $this->validate($request, [
					// 	"sentence".$i => 'string|max:10',
					// 	]);
    			$p4New->sentence = $sentence;
    			$t=time();
    			$t=date("Y-m-d-H-i-s",$t);
    			// $destinationPath = "audio/P4/lesson".$lesson->lessonNo;

    			// $extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
    			// $fileName = $p4New->sentenceNo."-".$t.'.'.$extension;

    			// Input::file("audioAdd".$i)->move($destinationPath, $fileName);
    			// $newName = "audio/P4/lesson".$lesson->lessonNo."/".$p4New->sentenceNo."-".$t.'.'.$extension;
    			
    			$data = $request["audioAdd".$i];
    			$destinationPath = "audio/P4/lesson".$lesson->lessonNo;
    			$extension = $data->getClientOriginalExtension();
    			$fileName = $i."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);

    			$p4New->audio = $newName;
    			$p4New->save();
    		}
    	}

    	$sumDelete = $request->all()['sumDelete'];
    	for ($i=0; $i <= $sumDelete ; $i++) { 
    		if ($request->exists("delete".$i)) {
    			$p4Edit = P4SentenceRecognize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
    		}
    	}
    	return Redirect("/listAct".$request->all()['lessonID']);
    }
}
