<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Situation;
use App\Lesson;
use Validator;
use Redirect;
use App\LessonNote;

class SituController extends Controller{

    public function load(Request $request, $lessonNo)
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
        if ($cnt != 0){
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
        $lesson = Lesson::find($request->all()['situaID']);
        $totalOld = $request->all()['sumOrigin'];
        $totalNew = $request->all()['sumLine'];


        if($totalNew >= $totalOld){
            for ($i=1; $i <= $totalOld ; $i++) { 
                $SituaEdit = Situation::where('lesson_id', '=', $request->all()['situaID'])->where('situationNo', '=', $i)->get();
                $dialog = str_replace("\n", "|", $request->all()["dialog".$i]);
                $SituaEdit[0]->dialog = $dialog;
                if($request->exists("imgPath".$i)){
                    $t=time();
                    $oldName = $request->all()["imgPath".$i];
                    $newName = "Situation_img/S".$i."-".$t.".".substr($oldName,-3,3);
                    
                    rename($oldName, $newName);
                    $SituaEdit[0]->thumbnail = $newName;
                }elseif($request->exists("image".$i)){
                    $t=time();
                    $destinationPath = 'Situation_img'; 
                    $extension = Input::file("image".$i)->getClientOriginalExtension();
                    $fileName = "S".$i."-".$t.'.'.$extension;
                    Input::file("image".$i)->move($destinationPath, $fileName);
                    $newName = "Situation_img/S".$i."-".$t.".".$extension;
                    $SituaEdit[0]->thumbnail = $newName;
                }else{
                    $SituaEdit[0]->thumbnail = "";
                }

                if($request->exists("audioPath".$i)){
                    $t=time();
                    $oldName = $request->all()["audioPath".$i];
                    $newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.".mp3";
                    rename($oldName, $newName);
                    $SituaEdit[0]->audio = $newName;
                }elseif($request->exists("audio".$i)){
                    $t=time();
                    $destinationPath = "audio/Situation/lesson".$lesson->lessonNo;
                    $extension = Input::file("image".$i)->getClientOriginalExtension();
                    $fileName = "S".$i."-".$t.'.'.$extension;
                    Input::file("audio".$i)->move($destinationPath, $fileName);
                    $newName = "audio/Situation/lesson".$lesson->lessonNo."/S".$i."-".$t.'.'.$extension;
                    $SituaEdit[0]->audio = $newName;
                }else{
                    $SituaEdit[0]->audio = "";
                }
                $SituaEdit[0]->save();
            }
            if ($totalNew > $totalOld) {
                for ($i=$totalOld; $i <= $totalNew ; $i++) { 
                    $SituaNew = new Situation;
                    $SituaNew->situationNo = $i;
                    $SituaNew->lesson_id = $request->all()['situaID'];
                    $SituaNew->dialog = $request->all()['situaID'];
                }
            }
        }elseif($totalNew < $totalOld){

        }
    }
}
