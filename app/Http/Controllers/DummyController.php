<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DummyController extends Controller
{
    public function load(Request $request)
    {
    	/*
    	** Lấy đường dẫn từ request
    	** Ví dụ localhost:8080/dummy sẽ cho ra $uri == dummy
    	*/
    	$uri = $request->path();

    	/*
    	** Tạo đường dẫn đầy đủ
    	*/
        $filePath = storage_path() . "/dummy/{$uri}.json";

		/*
    	** Kiểm tra xem đường dẫn và tên file có khớp nhau
    	** Nếu false -> kết thúc
    	*/
        if (!File::exists($filePath)) {
            dd("Tên file không khớp đường dẫn");
        }

	    /*
    	** Đọc data từ file và parse sang object
    	** Sửa $dummy = json_decode($dummyData); thành
    	** $dummy = json_decode($dummyData, trưe);
    	** để parse data sang array
    	*/
        $dummyData = File::get($filePath);
        $dummy = json_decode($dummyData);
        /*
        ** Thực hiện xử lý riêng cho từng màn hình
        ** Nếu không định sẵn xử lý, mặc định chuyển đến view tương ứng
        */
        switch ($uri) {
            case 'Situation':
            $cnt = count($dummy);
            if ($cnt != 0)
            {
                for ($i=0; $i<$cnt; $i++){
                    $contentArr[$i] = explode( "|", $dummy[$i]->content);
                }
                foreach ($dummy as $dummyValue) 
                {
                    $audioArr[] = $dummyValue->audio;
                } 
                return view("{$uri}", compact(['dummy', 'contentArr', 'audioArr', 'cnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }
            break;

            case 'P1':
            $firstLineNumber;

            if (count($dummy) != 0)
            {
                $firstLineNumber = $dummy[0]->lineNumber;
                return view("{$uri}", compact(['dummy', 'firstLineNumber']));
            } else {
                return view("{$uri}", compact('dummy'));
            }

            break;
            
            case 'P2':
            $lastIndex = $dummy[count($dummy)-1]->correctOrder;
            shuffle($dummy);
            return view("{$uri}", compact(['dummy', 'lastIndex']));

            break;
            
            case 'P4':
            shuffle($dummy);
            return view("{$uri}", compact('dummy'));

            break;

            case 'P5': 
            $cnt = count($dummy);

            if ($cnt != 0)
            {
                for ($i=0; $i<$cnt; $i++){
                    $contentArr[$i] = explode( "|", $dummy[$i]->content);

                }
                return view("{$uri}", compact(['dummy', 'contentArr', 'cnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }

            break;

            case 'P6':
            $all = [];

            foreach ($dummy as $dummyValue) {
                $newElem = (object) array(
                    "dialogNo"  => $dummyValue->dialogNo,
                    "dialog"    => $dummyValue->dialog,
                    "answers"   => [
                    "correctAnswer" => [
                    "content"   => $dummyValue->correctAnswer,
                    "chosen"    => false
                    ],
                    "wrongAnswer1" => [
                    "content"   => $dummyValue->wrongAnswer1,
                    "chosen"    => false
                    ],
                    "wrongAnswer2" => [
                    "content"   => $dummyValue->wrongAnswer2,
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

            $dummy = $all;

            return view("{$uri}", compact('dummy'));

            break;

            case 'P7':
            $cnt = count($dummy);
            if ($cnt != 0)
            {
                for ($i=0; $i<$cnt; $i++){
                    $contentArr[$i] = explode( "|", $dummy[$i]->content);
                }
                for ($i=0; $i<$cnt; $i++){
                    $audioArr[$i] = $dummy[$i]->audio;
                }
                return view("{$uri}", compact(['dummy', 'contentArr', 'audioArr', 'cnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }

            break;

            case 'P8':
            $cnt = count($dummy);
            $dialogCnt = array();
            $answerArrs = array();
            
            if ($cnt != 0){
                for ($i=0; $i<$cnt; $i++){
                    $dup = false;
                    for ($j=0; $j < count($dialogCnt) ; $j++) { 
                        if($dummy[$i]->dialogNo == $dialogCnt[$j]){
                            $dup = true;
                        }
                    }
                    if ($dup == false) {
                        array_push($dialogCnt, $dummy[$i]->dialogNo);
                    }
                }
                return view("{$uri}", compact(['dummy', 'dialogCnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }


            break;

            case 'P9':
            $cnt = count($dummy);
            $dialogCnt = array();
            $answerArrs = array();
            
            if ($cnt != 0){
                for ($i=0; $i<$cnt; $i++){
                    $dup = false;
                    for ($j=0; $j < count($dialogCnt) ; $j++) { 
                        if($dummy[$i]->dialogNo == $dialogCnt[$j]){
                            $dup = true;
                        }
                    }
                    if ($dup == false) {
                        array_push($dialogCnt, $dummy[$i]->dialogNo);
                    }
                }
                return view("{$uri}", compact(['dummy', 'dialogCnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }


            break;

            case 'P10':
            $initOrder = [];
            foreach ($dummy as $dummyValue) {
                $initOrder[] = $dummyValue->correctOrder;
            }

            $currentOrder;

            do {
                shuffle($dummy);

                $currentOrder = array();
                foreach ($dummy as $dummyValue) {
                    $currentOrder[] = $dummyValue->correctOrder;
                }
            } while ( $currentOrder === $initOrder );

            return view("{$uri}", compact('dummy'));

            break;

            case 'P11':
            $initOrder = [];
            $stArr = [];
            $cnt = count($dummy);
            foreach ($dummy as $dummyValue) {
                $initOrder[] = $dummyValue->correctOrder;
            }
            foreach ($dummy as $dummyValue) {
                $stArr[] = $dummyValue->sentence;
            }
            $currentOrder;

            do {
                shuffle($dummy);

                $currentOrder = array();
                foreach ($dummy as $dummyValue) {
                    $currentOrder[] = $dummyValue->correctOrder;
                }
            } while ( $currentOrder === $initOrder );
            
            return view("{$uri}", compact(['dummy', 'stArr', 'cnt']));

            break;

            case 'P12':

            return view("{$uri}", compact('dummy'));
            break;

            case 'P13':
            foreach ($dummy as $dummyValue) 
            {
                $noteArr = explode("|", $dummyValue->note);
            } 
            return view("{$uri}", compact(['dummy', 'noteArr'])); 
            break;

            case 'P14':
            foreach ($dummy as $dummyValue) 
            {
                $contentArr = explode("|", $dummyValue->content);
            } 
            return view("{$uri}", compact(['dummy', 'contentArr'])); 
            break;
            
            case 'P15':
            $cnt = count($dummy);
            if ($cnt != 0)
            {
                for ($i=0; $i<$cnt; $i++){
                    $contentArr[$i] = explode( "|", $dummy[$i]->content);
                }
                foreach ($dummy as $dummyValue) 
                {
                    $titleArr[] = $dummyValue->title;
                } 
                return view("{$uri}", compact(['dummy', 'contentArr', 'titleArr', 'cnt'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }
            break;

            default:
                /*
                ** Chuyển đến view trong điều kiện bình thường
                */
                return view("{$uri}", compact('dummy'));
                break;
            }
            
        }
    }
