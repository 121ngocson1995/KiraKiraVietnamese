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
    	 //　レッスンを取る。
    	$lesson = LessonController::getLesson($lessonNo);

		// get P2
		// P2を取る。
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
    		if ($request->exists("wordId".$i)) {


                $checkArray = array();
                $checkArray['word'.$i] = $request->all()['word'.$i];
                Validator::make($checkArray, [
                    'word'.$i => 'required|max:20',
                    ],
                    [
                    ])->validate();

    			$p2Edit = P2WordRecognize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["wordId".$i])->get();

				// $this->validate($request, [
				// 	"word".$i => 'string|max:10',
				// 	]);

    			$p2Edit[0]->word = $request->all()['word'.$i];

    			// if($request->exists("audioPath".$i)){
    			// 	$t=time();
    			// 	$t=date("Y-m-d-H-i-s",$t);
    			// 	$oldName = $request->all()["audioPath".$i];
    			// 	$newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
    			// 	rename($oldName, $newName);
    			// 	$p2Edit[0]->audio = $newName;
    			// }else 
                if($request->exists("audio".$i)){

    				$t=time();
    				$t=date("Y-m-d-H-i-s",$t);

					//---------------- OLD ----------------//
					//
					// $destinationPath = "audio/P2/lesson".$lesson->lessonNo;

					// $extension = Input::file("audio".$i)->getClientOriginalExtension();
					// $fileName = $i."-".$t.'.'.$extension;

					// Input::file("audio".$i)->move($destinationPath, $fileName);
					// $newName = "audio/P2/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					//---------------- NEW ----------------//

					$data = $request["audio".$i];	// tạo biến chứa file
    				$destinationPath = "audio/P2/lesson".$lesson->lessonNo; // tạo đường dẫn
    				$extension = $data->getClientOriginalExtension();	// tạo biến chứa đuôi file
    				$fileName = $i."-".$t.'.'.$extension;	// tạo tên file đầy đủ
    				$newName = $data->storeAs($destinationPath, $fileName);	// lưu file vào disk mặc định trong filesystems.php

    				//---------------- END ----------------//

    				$p2Edit[0]->audio = $newName;
    			}
    			$p2Edit[0]->save();
    		}
    	}

    	$sumAdd = $request->all()['sumAdd'];
    	for ($i=0; $i <= $sumAdd ; $i++) { 
    		if ($request->exists("wordAdd".$i)) {


                $checkArray = array();
                $checkArray['wordAdd'.$i] = $request->all()['wordAdd'.$i];
                Validator::make($checkArray, [
                    'wordAdd'.$i => 'required|max:20',
                    ],
                    [
                    ])->validate();

    			$p2New = new P2WordRecognize;
    			$p2New->lesson_id = $request->all()['lessonID'];
    			$word = $request->all()["wordAdd".$i];


					// $this->validate($request, [
					// 	"word".$i => 'string|max:10',
					// 	]);
    			$p2New->word = $word;
    			$t=time();
    			$t=date("Y-m-d-H-i-s",$t);
				// $destinationPath = "audio/P2/lesson".$lesson->lessonNo;

				// $extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
				// $fileName = $p2New->wordNo."-".$t.'.'.$extension;

				// Input::file("audioAdd".$i)->move($destinationPath, $fileName);
				// $newName = "audio/P2/lesson".$lesson->lessonNo."/".$p2New->wordNo."-".$t.'.'.$extension;
				// 
    			$data = $request["audioAdd".$i];
    			$destinationPath = "audio/P2/lesson".$lesson->lessonNo;
    			$extension = $data->getClientOriginalExtension();
    			$fileName = $i."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);
    			$p2New->audio = $newName;
    			$p2New->save();
    		}
    	}

    	$sumDelete = $request->all()['sumDelete'];
    	for ($i=0; $i <= $sumDelete ; $i++) { 
    		if ($request->exists("delete".$i)) {
    			$p2Edit = P2WordRecognize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
    		}
    	}
    	return Redirect("/listAct".$request->all()['lessonID']);
    }
}
