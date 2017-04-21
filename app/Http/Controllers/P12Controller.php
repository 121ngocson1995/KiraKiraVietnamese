<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P12GroupInteraction;
use Illuminate\Support\Facades\Validator;

class P12Controller extends Controller
{
	public function load(Request $request, $lessonNo)
	{
    	// get lesson
		$lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

    	// Lấy dữ liệu từ db
		$elementData = P12GroupInteraction::where('lesson_id', '=', $lesson_id)->get();
		return view("activities.P12", compact('elementData')); 
	}

	public function edit(Request $request)
	{
		// dd($request->all());
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

		return Redirect("/listAct".$request->all()['lessonId']);
	}
}
