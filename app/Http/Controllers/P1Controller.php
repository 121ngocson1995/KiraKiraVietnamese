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
    	$lesson = LessonController::getLesson($lessonNo);
    	$lesson_id = $lesson->id;

    	$elementData = P1WordMemorize::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);

    	return view("activities.P1v3", compact(['elementData', 'firstLineNumber']));
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
    	$lesson = Lesson::find($request->lessonID);
    	$totalNew = $request->all()['sumOrigin'];
    	// dd($request->all());
    	for ($i=0; $i <= $totalNew ; $i++) { 
    		if ($request->exists("wordId".$i)) {
    			$p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["wordId".$i])->get();

				// $this->validate($request, [
				// 	"word".$i => 'string|max:10',
				// 	]);

    			$p1Edit[0]->word = $request->all()['word'.$i];
    			$p1Edit[0]->wordNo = $i;

    			// if($request->exists("audioPath".$i)){
    				// $t=time();
    				// $t=date("Y-m-d-H-i-s",$t);
    				// $oldName = $request->all()["audioPath".$i];
    				// $newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.".mp3";
    				// rename($oldName, $newName);
    				// $p1Edit[0]->audio = $newName;
    			// }else 
                if($request->exists("audio".$i)){

                    $t=time();
                    $t=date("Y-m-d-H-i-s",$t);


					//---------------- OLD ----------------//

					// $destinationPath = "audio/P1/lesson".$lesson->lessonNo;

					// $extension = Input::file("audio".$i)->getClientOriginalExtension();
					// $fileName = $i."-".$t.'.'.$extension;

					// Input::file("audio".$i)->move($destinationPath, $fileName);
					// $newName = "audio/P1/lesson".$lesson->lessonNo."/".$i."-".$t.'.'.$extension;

					//---------------- NEW ----------------//

    				$data = $request["audio".$i];	// tạo biến chứa file
    				$destinationPath = "audio/P1/lesson".$lesson->lessonNo; // tạo đường dẫn
    				$extension = $data->getClientOriginalExtension();	// tạo biến chứa đuôi file
    				// dd($extension);
    				$fileName = $i."-".$t.'.'.$extension;	// tạo tên file đầy đủ
    				$newName = $data->storeAs($destinationPath, $fileName);	// lưu file vào disk mặc định trong filesystems.php

					//---------------- END ----------------//


    				$p1Edit[0]->audio = $newName;
    			}else{
    				$p1Edit[0]->audio = "";
    			}
    			$p1Edit[0]->save();
    		}
    	}

    	$sumAdd = $request->all()['sumAdd'];
    	for ($i=0; $i <= $sumAdd ; $i++) { 
    		if ($request->exists("wordAdd".$i)) {
    			$p1New = new P1WordMemorize;
    			$p1New->wordNo = $totalNew + $i;
    			$p1New->lesson_id = $request->all()['lessonID'];
    			$word = $request->all()["wordAdd".$i];

				// $this->validate($request, [
				// 	"word".$i => 'string|max:10',
				// 	]);
    			$p1New->word = $word;
    			$t=time();
    			$t=date("Y-m-d-H-i-s",$t);
    			// $destinationPath = "audio/P1/lesson".$lesson->lessonNo;

    			// $extension = Input::file("audioAdd".$i)->getClientOriginalExtension();
    			// $fileName = $p1New->wordNo."-".$t.'.'.$extension;

    			// Input::file("audioAdd".$i)->move($destinationPath, $fileName);
    			// $newName = "audio/P1/lesson".$lesson->lessonNo."/".$p1New->wordNo."-".$t.'.'.$extension;

    			$data = $request["audioAdd".$i];
    			$destinationPath = "audio/P1/lesson".$lesson->lessonNo;
    			$extension = $data->getClientOriginalExtension();
                $fileName = $p1New->wordNo."-".$t.'.'.$extension;
    			$newName = $data->storeAs($destinationPath, $fileName);

    			$p1New->audio = $newName;
    			$p1New->save();
    		}
    	}

    	$sumDelete = $request->all()['sumDelete'];
    	for ($i=0; $i <= $sumDelete ; $i++) { 
    		if ($request->exists("delete".$i)) {
    			$p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["delete".$i])->delete();
    		}
    	}
    	return Redirect("/listAct".$request->all()['lessonID']);
    }
}
