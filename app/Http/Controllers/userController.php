<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class userController extends Controller
{
   public function load()
	{
			// dummy course và lesson
		$user_id= Auth::id();
    		// Lấy dữ liệu từ db
		$userData = User::where('id', '=', $user_id)->get()->toArray();
		$roleData = Role::get();
		for ($i=0; $i <count($roleData) ; $i++) { 
			if ($roleData[$i]->id == $userData[0]['role']) {
				$userData[0]['roleTitle'] = $roleData[$i]->role_title;
			}
		}
		// $userData = array();
		// $userData[] = [
		// 	"id" => $data[0]['id'],
		// 	"firstName" => $data[0]['first_name'],
		// 	"lastName" => $data[0]['last_name'],
		// 	"email" => $data[0]['email'],
		// 	"gender" => $data[0]['gender'],
		// 	"birthday" =>  $data[0]['date_of_birth'],
		// 	"language" =>  $data[0]['language'],
		// 	"country" =>  $data[0]['country'],
		// 	"role" =>  $data[0]['role']
		// ];
		// `// $userData[0]['date_of_birth'] = date_format($date, 'F d Y');
       return view("info", compact('userData'));
    }

    public function edit(Request $request)
	{
    		// Lấy dữ liệu từ db;
		$user_id= Auth::id();
		$userData = User::find($user_id);

		$userData->email = $request->input('txtEmail');
		$userData->date_of_birth = $request->input('txtDOB');
		$userData->gender = $request->input('txtGender');
		$userData->language = $request->input('txtLanguage');
		$userData->country = $request->input('txtCountry');
		$userData->save();
		$userData = User::where('id', '=', $user_id)->get()->toArray();
       return view("info", compact('userData'));
    }
}
