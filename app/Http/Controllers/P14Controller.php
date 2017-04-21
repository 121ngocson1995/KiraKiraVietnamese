<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P14SentencePattern;
use \DB;

class P14Controller extends Controller
{
    public function load(Request $request, $lessonNo)
    {
        // get lesson
        $lesson = LessonController::getLesson($lessonNo);
        $lesson_id = $lesson->id;

        // Lấy dữ liệu từ db
        $elementData = P14SentencePattern::where('lesson_id', '=', $lesson_id)->orderBy('sentenceNo')->get();

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

    public function edit(Request $request)
    {
        // dd($request->all());
        if ($request->has('update')) {
            foreach ($request->update as $id => $value) {
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
                    'sentenceNo' => preg_replace('/\*\*+/', '*', trim(trim($sentence, ' '), '*')),
                    'sentence' => $value['sentenceNo'],
                    ]);
            }
        }

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                P14SentencePattern::where('id', '=', $id)->delete();
            }
        }

        return Redirect("/listAct".$request->all()['lessonId']);
    }
}