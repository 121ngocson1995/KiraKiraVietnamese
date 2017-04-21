<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P10SentenceReorder;

class P10Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
    	// get lesson
		$lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$data = P10SentenceReorder::where('lesson_id', '=', $lesson_id)->orderBy('sentenceNo', 'asc')->get();

		$curSentenceNo = 0;

		/* restructure elementData */
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

		/* shuffle words in elementData */
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

	public function edit(Request $request)
	{
		dd($request->all());
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

				$p10Element->sentenceNo = $sentenceNo;
				$p10Element->correctOrder = $lastOrder++;
				$p10Element->word = $value['word'];

				P10SentenceReorder::create([
					'lesson_id' => $request->lessonId,
					'sentenceNo' => $sentenceNo,
					'word' => $value['word'],
					'correctOrder' => $lastOrder++,
					]);
			}
		}

		if ($request->has('delete')) {
			foreach (explode(',', $request->delete) as $id) {
				P10SentenceReorder::where('id', '=', $id)->delete();
			}
		}

		return Redirect("/listAct".$request->all()['lessonId']);
	}
}
