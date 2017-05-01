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
        if (count($lesson) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The lesson you\'ve chosen has yet been created.');
            return back();
        }

        $lesson_id = $lesson->id;

        $elementData = P1WordMemorize::where('lesson_id', '=', $lesson_id)->get();
        $cnt = count($elementData);
        if ($cnt == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }

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
    	
    	for ($i=0; $i <= $totalNew ; $i++) { 
    		if ($request->exists("wordId".$i)) {

                $checkArray = array();
                $checkArray['word'.$i] = $request->all()['word'.$i];

                Validator::make($checkArray, [
                    'word'.$i => 'required|max:20',
                    ],
                    [
                    ])->validate();

                $p1Edit = P1WordMemorize::where('lesson_id', '=', $request->all()['lessonID'])->where('id', '=', $request->all()["wordId".$i])->get();

                $p1Edit[0]->word = $request->all()['word'.$i];
                $p1Edit[0]->wordNo = $i;

                if($request->exists("audio".$i)){
                    $t=time();
                    $t=date("Y-m-d-H-i-s",$t);

    				$data = $request["audio".$i];
    				$destinationPath = "audio/P1/lesson".$lesson->lessonNo;
    				$extension = $data->getClientOriginalExtension();
    				$fileName = $i."-".$t.'.'.$extension;
    				$newName = $data->storeAs($destinationPath, $fileName);

    				$p1Edit[0]->audio = $newName;
    			}
    			$p1Edit[0]->save();
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

                $p1New = new P1WordMemorize;
                $p1New->wordNo = $totalNew + $i;
                $p1New->lesson_id = $request->all()['lessonID'];
                $word = $request->all()["wordAdd".$i];

                $p1New->word = $word;
                $t=time();
                $t=date("Y-m-d-H-i-s",$t);

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

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

        return Redirect("/listAct".$request->all()['lessonID']);
    }
}