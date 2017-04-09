<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P11ConversationReorder;

class P11Controller extends Controller
{
    public function load()
    {
    	// dummy course và lesson
    	$course_id= 1;
    	$lesson_id= 1;

		// Lấy dữ liệu từ db
		$elementData = P11ConversationReorder::where('lesson_id', '=', $lesson_id)->orderBy('correctOrder', 'asc')->get();
    	$initOrder = [];
    	$correctAnswer = [];

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

        $correctAnswerList = $this->arrange($answerListPreArranged);

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
}
