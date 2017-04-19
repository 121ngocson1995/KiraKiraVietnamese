<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P11ConversationReorder;

class P11Controller extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'load']);
    }

    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
        $lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P11ConversationReorder::where('lesson_id', '=', $lesson_id)->orderBy('correctOrder', 'asc')->get();
    	$initOrder = [];
    	$correctAnswer = [];

        $correctAnswerList = $this->makeAnswerListWithSentence($elementData);

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

    	return view("activities.P11v2", compact(['elementData', 'correctAnswerList']));
    }

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

    private function arrange($answerListPreArranged)
    {
        $result = array();

        foreach ($answerListPreArranged as $answer) {
            $result[] = $this->sort($answer);
        }

        return $result;
    }

    private function sort($answer)
    {
        array_multisort($answer['order'], $answer['sentence']);
        return $answer['sentence'];
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        foreach ($request->update as $id => $value) {
            $p11Element = P11ConversationReorder::where('id', '=', $id)->first();
                
            if (strcmp($p11Element->sentence, $value['sentence']) != 0) {
                $p11Element->sentence = $value['sentence'];
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

        if ($request->has('insert')) {
            foreach ($request->insert as $id => $value) {
                if (strcmp($p11Element->sentence, $value['sentence']) != 0) {
                    $p11Element->sentence = $value['sentence'];
                }

                $correctOrder = '';
                for ($i=0; $i < count($value['order']); $i++) { 
                    if ($i != 0) {
                        $correctOrder .= ',';
                    }
                    $correctOrder .= (integer)$value['order'][$i] - 1;
                }

                P11ConversationReorder::create([
                    'lesson_id' => $request->lessonId,
                    'sentence' => $value['sentence'],
                    'correctOrder' => $correctOrder,
                ]);
            }
        }

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                P11ConversationReorder::where('id', '=', $id)->delete();
            }
        }

        return Redirect("/listAct".$request->all()['lessonId']);
    }
}
