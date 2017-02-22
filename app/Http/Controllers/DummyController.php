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
            
            case 'P3':
            $firstLineNumber;

            if (count($dummy) != 0)
            {
                $firstLineNumber = $dummy[0]->lineNumber;
                return view("{$uri}", compact(['dummy', 'firstLineNumber']));
            } else {
                return view("{$uri}", compact('dummy'));
            }

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

            case 'P6': 
            $cnt = count($dummy);
            if ($cnt != 0)
            {
                for ($i=0; $i<$cnt; $i++){
                    $problemArr[$i] = explode( "|", $dummy[$i]->problem);
                    $answerArr[$i] = explode( "|", $dummy[$i]->answer);
                }
                return view("{$uri}", compact(['dummy', 'problemArr', 'answerArr', 'cnt', 'arr'])); 
            } else {
                return view("{$uri}", compact('dummy'));
            }

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

            default:    
                /*
                ** Chuyển đến view trong điều kiện bình thường
                */
                return view("{$uri}", compact('dummy'));
                break;
            }
        }
    }
