<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\P11ConversationReorder;

class P11Controller extends Controller
{
    /**
    * Create a new controller instance.
    *　新しいコントローラーのインスタンスを作成する。
    *
    * @return void
    */
    public function __construct()
    {
        // $this->middleware('auth', ['except' => 'load']);
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
        $elementData = P11ConversationReorder::where('lesson_id', '=', $lesson_id)->orderBy('correctOrder', 'asc')->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }
        $initOrder = [];
        $correctAnswer = [];

        $correctAnswerList = $this->makeAnswerListWithSentence($elementData);

        if ( count($elementData) > 1 ) {
            foreach ($elementData as $key) {
                $initOrder[] = $key->correctOrder;
            }

            $currentOrder;
            do {
                $elementData = $elementData->shuffle();
                $currentOrder = array();
                foreach ($elementData as $key) {
                    $currentOrder[] = $key->correctOrder;
                }
            } while ( $currentOrder === $initOrder );
        };

    	return view("activities.P11v2", compact(['elementData', 'correctAnswerList']));
    }

    /**
     * Create a list with all possible answers.
     *　すべての可能な回答のリストを作成する。
     *
     * @param Collection $elementData
     *
     * @return Array
     */
    public function makeAnswerListWithSentence(\Illuminate\Database\Eloquent\Collection $elementData)
    {
        $answerListRaw = array();
        foreach ($elementData as $elementValue) {
            $answer = array();
            $answer['sentence'] = $elementValue->sentence;
            $answer['order'] = explode(',', $elementValue->correctOrder);

            $answerListRaw[] = $answer;
        }

        $answerListPreArranged = array();
        for ($i=0; $i < count($answerListRaw[0]['order']); $i++) {
            for ($j=0; $j < count($answerListRaw); $j++) {
                if (count($answerListPreArranged) == $i) {
                    $answerNew = array();
                    $answerNew['sentence'] = array();
                    $answerNew['sentence'][] = $answerListRaw[$j]['sentence'];
                    $answerNew['order'][] = (int)preg_replace('#[^0-9]+#', '', $answerListRaw[$j]['order'][$i]);

                    $answerListPreArranged[] = $answerNew;
                } else {
                    $answerListPreArranged[$i]['sentence'][] = $answerListRaw[$j]['sentence'];
                    $answerListPreArranged[$i]['order'][] = (int)preg_replace('#[^0-9]+#', '', $answerListRaw[$j]['order'][$i]);
                }
            }
        }

        return $this->arrange($answerListPreArranged);
    }

    /**
     * Reorder the answer list based on "correctOrder" field.
     *　「correctOrder」によって、回答のリストを並べ替える。
     *
     * @param Array $answerListPreArranged
     *
     * @return Array
     */
    private function arrange($answerListPreArranged)
    {
        $result = array();

        foreach ($answerListPreArranged as $answer) {
            $result[] = $this->sort($answer);
        }

        return $result;
    }

    /**
     * Perform sorting on the given array.
     *　指定されたアレイで並べ替えることを行う。
     *
     * @param Array $answer
     *
     * @return Array
     */
    private function sort($answer)
    {
        array_multisort($answer['order'], $answer['sentence']);
        return $answer['sentence'];
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
                    'sentence'=> 'required|max:80',
                    'order.*'=> 'numberic',
                    ],
                    [
                    ])->validate();
                $p11Element = P11ConversationReorder::where('id', '=', $id)->first();
                    
                if (strcmp($p11Element->sentence, $value['sentence']) != 0) {
                    $newSentence = $value['sentence'];

                    while (strcmp($newSentence[0], '-') == 0 || strcmp($newSentence[0], ' ') == 0) {
                        $newSentence = trim($newSentence, '-');
                        $newSentence = trim($newSentence, ' ');
                    }

                    $p11Element->sentence = '- ' . $newSentence;
                }

                $correctOrder = '';
                $start = true;
                foreach ($value['order'] as $key => $order) { 
                    if ($start) {
                        $start = false;
                    } else {
                        $correctOrder .= ',';
                    }
                    $correctOrder .= (integer)$value['order'][$key] - 1;
                }

                $p11Element->correctOrder = $correctOrder;
                $p11Element->save();
            }
        }

        if ($request->has('insert')) {
            foreach ($request->insert as $id => $value) {
                $newSentence = $value['sentence'];

                while (strcmp($newSentence[0], '-') == 0 || strcmp($newSentence[0], ' ') == 0) {
                    // $newSentence = trim($newSentence, '-');
                    $newSentence = trim($newSentence, ' ');
                }

                // $newSentence = '- ' . $newSentence;

                $correctOrder = '';
                $start = true;
                foreach ($value['order'] as $key => $order) { 
                    if ($start) {
                        $start = false;
                    } else {
                        $correctOrder .= ',';
                    }
                    $correctOrder .= (integer)$value['order'][$key] - 1;
                }

                P11ConversationReorder::create([
                    'lesson_id' => $request->lessonId,
                    'sentence' => $newSentence,
                    'correctOrder' => $correctOrder,
                ]);
            }
        }

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                P11ConversationReorder::where('id', '=', $id)->delete();
            }
        }

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

        return Redirect("/listAct".$request->all()['lessonId']);
    }
}
