<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\P10SentenceReorder;

class P10Controller extends Controller
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
     *　データベースからデータを出す。
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
		$data = P10SentenceReorder::where('lesson_id', '=', $lesson_id)->orderBy('sentenceNo', 'asc')->get();
        if (count($data) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }

		$curSentenceNo = 0;

		// restructure elementData 
		// 「elementData」を再構築する。
		$elementData = array();
		$curElement = array();
		foreach ($data as $dataValue) {
			if ($dataValue->sentenceNo != $curSentenceNo) {
				if ($curSentenceNo != 0) {
					$elementData[] = $curElement;
					$curElement = array();
				}
				$curSentenceNo = $dataValue->sentenceNo;
			}
			
			$curElement[] = $dataValue;
		}
		$elementData[] = $curElement;

		//　shuffle words in elementData 
		//　「elementData 」での単語を苦しむ。
		for ($i=0; $i < count($elementData); $i++) { 
			$initOrder = [];
			foreach ($elementData[$i] as $elementValue) {
				$initOrder[] = $elementValue->correctOrder;
			}

			$currentOrder;

			do {
				shuffle($elementData[$i]);

				$currentOrder = array();
				foreach ($elementData[$i] as $elementValue) {
					$currentOrder[] = $elementValue->correctOrder;
				}
			} while ( $currentOrder === $initOrder );
		}

		return view("activities.P10v2", compact('elementData'));
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
    	$lesson = Lesson::find($request->lessonId);
		if ($request->has('update')) {
			$lastSentenceNo = 0;
			$lastOrder = 0;
			foreach ($request->update as $id => $value) {
				$p10Element = P10SentenceReorder::where('id', '=', $id)->first();

				$sentenceNo = (integer)($value['sentenceNo']);
				if ($sentenceNo != $lastSentenceNo) {
					$lastSentenceNo = $sentenceNo;

					$lastOrder = 0;
				}

				$p10Element->sentenceNo = $sentenceNo;
				$p10Element->correctOrder = $lastOrder++;
				$p10Element->word = $value['word'];

				$p10Element->save();
			}
		}

		if ($request->has('insert')) {
			$lastSentenceNo = 0;
			$lastOrder = 0;
			foreach ($request->insert as $id => $value) {
				$sentenceNo = (integer)($value['sentenceNo']);
				if ($sentenceNo != $lastSentenceNo) {
					$lastSentenceNo = $sentenceNo;

					$lastOrder = 0;
				}

				P10SentenceReorder::create([
					'lesson_id' => $request->lessonId,
					'sentenceNo' => $sentenceNo,
					'word' => $value['word'],
					'correctOrder' => $lastOrder++
					]);
			}
		}

		if ($request->has('delete')) {
			foreach (explode(',', $request->delete) as $id) {
				P10SentenceReorder::where('id', '=', $id)->delete();
			}
		}

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

		return redirect("/listAct".$request->all()['lessonId']);
	}
}
