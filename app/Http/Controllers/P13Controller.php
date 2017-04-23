<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\P13Text;
use Illuminate\Support\Facades\Validator;

class P13Controller extends Controller
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
        $lesson_id = $lesson->id;

    	// Load data from Database
        // データベースからデータを出す。
        $elementData = P13Text::where('lesson_id', '=', $lesson_id)->get();

        foreach ($elementData as $value) 
        {
            $noteArr = explode("|", $value->note);
            $noteArrEn = explode("|", $value->note_translate);
        } 

        return view("activities.P13", compact(['elementData', 'noteArr', 'noteArrEn'])); 
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
        if ($request->has('update')) {
            foreach ($request->update as $id => $value) {
                Validator::make($value, [
                    'text' => 'string|max:191',
                    'note' => 'string|max:191',
                    'note_translate' => 'string|max:191',
                    ])->validate();

                $p13Element = P13Text::where('id', '=', $id)->first();

                $p13Element->content = $value['text'];
                $p13Element->note = $value['note'];
                $p13Element->note_translate = $value['note_translate'];

                $p13Element->save();
            }
        }

        if ($request->has('insert')) {
            $value = $request->insert;
            Validator::make($value, [
                'content' => 'string|max:191',
                'note' => 'string|max:191',
                'note_translate' => 'string|max:191',
                ])->validate();

            P13Text::create([
                'lesson_id' => $request->lessonId,
                'content' => $value['text'],
                'note' => $value['note'],
                'note_translate' => $value['note_translate'],
                ]);
        }

        if ($request->has('delete')) {
            foreach (explode(',', $request->delete) as $id) {
                P13Text::where('id', '=', $id)->delete();
            }
        }

        return Redirect("/listAct".$request->all()['lessonId']);
    }
}
