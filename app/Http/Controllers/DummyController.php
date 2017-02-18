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
    	** Chuyển đến view
    	*/
		return view("{$uri}", compact('dummy'));
    }
}
