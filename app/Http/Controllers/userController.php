<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class userController extends Controller
{
   public function load()
	{
			// dummy course và lesson
		$user_id= 1;
    		// Lấy dữ liệu từ db
		$data = User::where('id', '=', $user_id)->get()->toArray();

		$userData = array();
		$userData[] = [
			"id" => $data[0]['id'],
			"firstName" => $data[0]['first_name'],
			"lastName" => $data[0]['last_name'],
			"email" => $data[0]['email'],
			"gender" => $data[0]['gender'],
			"birthday" =>  $data[0]['date_of_birth'],
			"language" =>  $data[0]['language'],
			"country" =>  $data[0]['country'],
			"role" =>  $data[0]['role']
		];
		
       return view("test", compact($userData));
    }
}
