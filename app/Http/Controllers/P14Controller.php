<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\P14SentencePattern;
use \DB;
use Illuminate\Support\Facades\Validator; 

class P14Controller extends Controller
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
        $elementData = P14SentencePattern::where('lesson_id', '=', $lesson_id)->orderBy('sentenceNo')->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }

        $sentences = array();
        foreach ($elementData as $element) {
            $parts = array();

            foreach (explode( "*", $element->sentence) as $part) {
                $parts[] = explode('|', $part);
            }

            $sentences[] = $parts;
        }
        return view("activities.P14", compact(['sentences'])); 
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
            foreach ($request->update as $id => $value) {
                Validator::make($value, [
                    'sentence.*' => 'max:200',
                    ],
                    [
                    ])->validate();
                $p14Element = P14SentencePattern::where('id', '=', $id)->first();

                $sentence = '';

                foreach ($value['sentence'] as $part) {
                    if (count($part) == 1) {
                        $sentence .= $part[0];
                    } else {
                        $partCombined = '*';
                        foreach ($part as $option) {
                            $partCombined .= $option . '|';
                        }
                        $sentence .= rtrim($partCombined, '|') . '*';
                    }
                }

                $p14Element->sentence = preg_replace('/\*\*+/', '*', trim(trim($sentence, ' '), '*'));

                if ($p14Element->sentenceNo != (integer)($value['sentenceNo'])) {
                    $newSentenceNo = $value['sentenceNo'];

                    $p14Element->sentenceNo = $newSentenceNo;
                }

                $p14Element->save();
            }
        }

        if ($request->has('insert')) {
            foreach ($request->insert as $id => $value) {
                $newSentence = $value['sentence'];

                $sentence = '';

                foreach ($value['sentence'] as $part) {
                    if (count($part) == 1) {
                        $sentence .= $part[0];
                    } else {
                        $partCombined = '*';
                        foreach ($part as $option) {
                            $partCombined .= $option . '|';
                        }
                        $sentence .= rtrim($partCombined, '|') . '*';
                    }
                }

                P14SentencePattern::create([
                    'lesson_id' => $request->lessonId,
                    'sentenceNo' => $value['sentenceNo'],
                    'sentence' => preg_replace('/\*\*+/', '*', trim(trim($sentence, ' '), '*')),
                    ]);
            }
        }

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                P14SentencePattern::where('id', '=', $id)->delete();
            }
        }

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

        return Redirect("/listAct".$request->all()['lessonId']);
    }
}