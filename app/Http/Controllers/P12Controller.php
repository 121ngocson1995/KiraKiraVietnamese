<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P12GroupInteraction;
use Illuminate\Support\Facades\Validator;

class P12Controller extends Controller
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
		$elementData = P12GroupInteraction::where('lesson_id', '=', $lesson_id)->get();
		return view("activities.P12", compact('elementData')); 
	}

    /**
     * Update database based on user's input.
     *　ユーザーからの入力によって、データベースを更新する。
     *
     * @param Request $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
	public function edit(Request $request)
	{
		if ($request->has('update')) {
			foreach ($request->update as $id => $value) {
				Validator::make($value, [
					'content' => 'string|max:191',
					'content_translate' => 'string|max:191',
					])->validate();

				$p12Element = P12GroupInteraction::where('id', '=', $id)->first();

				$p12Element->content = $value['content'];
				$p12Element->content_translate = $value['content_translate'];

				$p12Element->save();
			}
		}

		if ($request->has('insert')) {
			$value = $request->insert;
			Validator::make($value, [
				'content' => 'string|max:191',
				'content_translate' => 'string|max:191',
				])->validate();

			P12GroupInteraction::create([
				'lesson_id' => $request->lessonId,
				'content' => $value['content'],
				'content_translate' => $value['content_translate'],
				]);
		}

		if ($request->has('delete')) {
			foreach (explode(',', $request->delete) as $id) {
				P12GroupInteraction::where('id', '=', $id)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['lessonId']);
	}
}
