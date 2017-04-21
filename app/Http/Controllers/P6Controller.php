<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P6DialogueMultipleChoice;

class P6Controller extends Controller
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
    
    /**
     * Load data from database.
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
	public function load(Request $request, $lessonNo)
	{
    	// get lesson
		$lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
		$elementData = P6DialogueMultipleChoice::where('lesson_id', '=', $lesson_id)->get();
		$cnt = count($elementData);

		$elementData = $this->shuffleAnswer($elementData);

		return view("activities.P6v3", compact(['elementData', 'cnt']));
	}

    /**
     * Update database based on user's input.
     *
     * @param Request $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
	public function edit(Request $request)
	{
		// dd($request->all());
		if ($request->has('update')) {
			foreach ($request->update as $id => $value) {
				$p6Element = P6DialogueMultipleChoice::where('id', '=', $id)->first();

				$sentences = preg_split('/\r\n/u', $value['dialog']);
				$dialog = '';
				for ($i=0; $i < count($sentences); $i++) { 
					if ($i != 0) {
						$dialog .= '|';
					}
					$dialog .= '- ' . trim(preg_replace('/\s\s+|^-/u', ' ', $sentences[$i]));
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
				$sentences = preg_split('/\r\n/u', $value['dialog']);
				$dialog = '';
				for ($i=0; $i < count($sentences); $i++) { 
					if ($i != 0) {
						$dialog .= '|';
					}
					$dialog .= '- ' . trim(preg_replace('/\s\s+|^-/u', ' ', $sentences[$i]));
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

		return Redirect("/listAct".$request->all()['lessonId']);
	}

    /**
     * Shuffle data taken from database so that the choices will be given at random.
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

			return $all;
		}
	}
}
