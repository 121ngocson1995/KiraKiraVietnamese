<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

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
		return view("info", compact('userData'));
	}

	public function edit(Request $request)
	{
		// Lấy dữ liệu từ db;
		$user_id= Auth::id();
		$userData = User::find($user_id);

		$todayDate = date("Y/m/d");

		Validator::extend('18yo', function ($attribute, $value, $parameters, $validator) {
			return strtotime($value) <= strtotime('-18 years');
		});

		Validator::make($request->all(), [
			'first-name' => 'required|alpha|max:30',
			'last-name' => 'required|alpha|max:30',
			'username' => [
			'required',
			'alpha_dash',
			'max:191',
			Rule::unique('users')->ignore($user_id),
			],
			'email' => [
			'required',
			'email',
			'max:191',
			Rule::unique('users')->ignore($user_id),
			],
			'gender' => 'numeric|between:0,1',
			'date-of-birth' => 'required|date|before:' . $todayDate .'|18yo',
			],
			[
			'18yo' => 'You must be 18 years or older',
			])->validate();

		$userData->first_name = $request->input('first-name');
		$userData->last_name = $request->input('last-name');
		$userData->username = $request->input('username');
		$userData->email = $request->input('email');
		$userData->date_of_birth = $request->input('date-of-birth');
		$userData->gender = $request->input('gender');
		// $userData->language = $request->input('language');
		// $userData->country = $request->input('country');
		$userData->save();

		return redirect("/userManage");
	}
}