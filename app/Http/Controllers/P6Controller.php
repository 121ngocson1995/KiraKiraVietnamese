<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\P6DialogueMultipleChoice;
use Illuminate\Support\Facades\Validator;

class P6Controller extends Controller
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
		$elementData = P6DialogueMultipleChoice::where('lesson_id', '=', $lesson_id)->get();
        if (count($elementData) == 0) {
            $request->session()->flash('alert-warning', 'Sorry! The activity you\'ve chosen has yet been created.');
            return back();
        }
		$cnt = count($elementData);

		$elementData = $this->shuffleAnswer($elementData);

		return view("activities.P6v3", compact(['elementData', 'cnt']));
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
		$lesson = Lesson::find($request->all()['lessonId']);
		if ($request->has('update')) {
			foreach ($request->update as $id => $value) {
				Validator::make($value, [
					'dialog' => 'string|max:200',
					'answers.*.correct' => 'string|max:20',
					'answers.*.wrong1' => 'string|max:20',
					'answers.*.wrong2' => 'string|max:20',
					])->validate();

				$p6Element = P6DialogueMultipleChoice::where('id', '=', $id)->first();

				$sentences = preg_split('/\r\n/u', $value['dialog']);
				$dialog = '';
				for ($i=0; $i < count($sentences); $i++) { 
					if ($i != 0) {
						$dialog .= '|';
					}
					$dialog .= trim(preg_replace('/\s\s+|^-/u', ' ', $sentences[$i]));
				}

				$p6Element->dialogNo = $value['dialogNo'];
				$p6Element->dialog = $dialog;
				$p6Element->correctAnswer = trim(preg_replace('/\s\s+/u', ' ', $value['answers']['correct']));
				$p6Element->wrongAnswer1 = trim(preg_replace('/\s\s+/u', ' ', $value['answers']['wrong1']));
				$p6Element->wrongAnswer2 = trim(preg_replace('/\s\s+/u', ' ', $value['answers']['wrong2']));

				$p6Element->save();
			}
		}

		if ($request->has('insert')) {
			foreach ($request->insert as $id => $value) {
				Validator::make($value, [
					'dialog' => 'string|max:200',
					'answers.*.correct' => 'string|max:20',
					'answers.*.wrong1' => 'string|max:20',
					'answers.*.wrong2' => 'string|max:20',
					])->validate();
				$sentences = preg_split('/\r\n/u', $value['dialog']);
				$dialog = '';
				for ($i=0; $i < count($sentences); $i++) { 
					if ($i != 0) {
						$dialog .= '|';
					}
					$dialog .= trim(preg_replace('/\s\s+/u', ' ', $sentences[$i]));
				}

				P6DialogueMultipleChoice::create([
					'lesson_id' => $request->lessonId,
					'dialogNo' => $value['dialogNo'],
					'dialog' => $dialog,
					'correctAnswer' => trim(preg_replace('/\s\s+/u', ' ', $value['answers']['correct'])),
					'wrongAnswer1' => trim(preg_replace('/\s\s+/u', ' ', $value['answers']['wrong1'])),
					'wrongAnswer2' => trim(preg_replace('/\s\s+/u', ' ', $value['answers']['wrong2'])),
					]);
			}
		}

		if ($request->has('delete')) {
			foreach (explode(',', $request->delete) as $id) {
				P6DialogueMultipleChoice::where('id', '=', $id)->delete();
			}
		}

        $course = \App\Course::where('id', '=', $lesson->course_id)->first();
        $course->last_updated_by = \Auth::user()->id;
        $course->save();

		return Redirect("/listAct".$request->all()['lessonId']);
	}

    /**
     * Shuffle data taken from database so that the choices will be given at random.
     *　データベースから取ったデータがシャッフルされたから選択がランダムに与えられる。
     *
     * @param Collection $elementData
     *
     * @return Array
     */
	public function shuffleAnswer($elementData)
	{
		$all = [];

		foreach ($elementData as $elementValue) {
			$newElem = (object) array(
				"dialogNo"  => $elementValue->dialogNo,
				"dialog"    => $elementValue->dialog,
				"answers"   => [
				"correctAnswer" => [
				"content"   => $elementValue->correctAnswer,
				"chosen"    => false
				],
				"wrongAnswer1" => [
				"content"   => $elementValue->wrongAnswer1,
				"chosen"    => false
				],
				"wrongAnswer2" => [
				"content"   => $elementValue->wrongAnswer2,
				"chosen"    => false
				]
				],
				"answerOrder" => [
				"correctAnswer",
				"wrongAnswer1",
				"wrongAnswer2"
				]
				);

			shuffle($newElem->answerOrder);

			$all[] = $newElem;

		}
		return $all;
	}
}
