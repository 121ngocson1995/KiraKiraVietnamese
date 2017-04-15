<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Situation;
use Validator;
use Redirect;
use App\LessonNote;

class SituController extends Controller
{
    public function load(Request $request, $lessonNo)
    {
    	// get lesson
        $lesson = LessonController::getLesson($lessonNo);
		$lesson_id = $lesson->id;

		// Lấy dữ liệu từ db
        $noteData = LessonNote::where('lesson_id', '=', $lesson_id)->orderBy('noteNo', 'asc')->get();
        $cnt = count($noteData);
        if ($cnt != 0)
        {
            for ($i=0; $i<$cnt; $i++){
                $note_content[$i] = explode( "|", $noteData[$i]->content);
            }
        }

        $elementData = Situation::where('lesson_id', '=', $lesson_id)->get();
    	$cnt = count($elementData);
    	if ($cnt != 0)
    	{
    		for ($i=0; $i<$cnt; $i++){
                $dialogArr[$i] = explode( "|", $elementData[$i]->dialog);
    			$dialogArrEn[$i] = explode( "|", $elementData[$i]->dialog_translate);
                $audioArr[$i] =  $elementData[$i]->audio;
    		}

    		return view("activities.Situationv2", compact(['elementData', 'note_content', 'audioArr', 'dialogArr', 'dialogArrEn'])); 
    		
    	} else {
    		return view("activities.Situationv2", compact(['elementData', 'note_content']));
    	}
    }

    public function edit(Request $request) {
        // getting all of the post data
        dd($request);
        $file = array('image' => $request->all()['image1']);
        
        // setting up rules
        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
        // send back to the page with the input data and errors
            return Redirect::to('upload')->withInput()->withErrors($validator);
        }
        else {
        // checking file is valid.
            if (Input::file('image1')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('image1')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                Input::file('image1')->move($destinationPath, $fileName); // uploading file to given path
                  // sending back with message
                Session::flash('success',  $path); 
                return Redirect::to('upload');
            }
            else {
            // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('upload');
            }
        }
      }
}
