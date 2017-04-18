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

	public function index(Request $request, $type='all', $username='%', $email='%', $pagination=5)
	{
		$users = User::latest('created_at')->paginate($pagination);

		if($request->ajax()) {
			if (strcmp($request->input('type'), 'pending') == 0 || strcmp($request->input('type'), 'rejected') == 0 || strcmp($request->input('type'), 'all') == 0 || strcmp($request->input('type'), 'admins') == 0 || strcmp($request->input('type'), 'teachers') == 0 || strcmp($request->input('type'), 'learners') == 0) {
				
				$type = $request->input('type');

			}

			if (strcmp($type, 'pending') == 0 || strcmp($type, 'rejected') == 0) {
				$users;

				if (strcmp($type, 'pending') == 0) {
					$users = User::where('role', '=', 1)->latest('created_at')->paginate($pagination);
				} else {
					$users = User::where('role', '=', 0)->latest('created_at')->paginate($pagination);
				}

				return view('userList.applicants', ['users' => $users])->render();

			} else if (strcmp($type, 'all') == 0 || strcmp($type, 'admins') == 0 || strcmp($type, 'teachers') == 0 || strcmp($type, 'learners') == 0) {

				if (strcmp($type, 'all') == 0) {
					$users = User::latest('created_at')->paginate($pagination);
				} else if (strcmp($type, 'leaners') == 0) {
					$users = User::where('role', '=', 2)->latest('created_at')->paginate($pagination);
				} else if (strcmp($type, 'teachers') == 0) {
					$users = User::where('role', '=', 3)->latest('created_at')->paginate($pagination);
				} else if (strcmp($type, 'admins') == 0) {
					$users = User::where('role', '=', 10)->orWhere('role', '=', 100)->latest('created_at')->paginate($pagination);
				}

				return view('userList.normal', ['users' => $users])->render();

			}
		}

		return view('userList.index', compact(['users']));
	}

	public function setRole(Request $request)
	{
		Validator::make($request->all(), [
			'userid' => 'exists:users,id',
			'oldRole' => 'exists:roles,id',
			'newRole' => 'exists:roles,id'
		])->validate();

		$user = User::where('id', '=', $request->input('userid'))->first();

		$user->role = (int)($request->input('newRole'));
		
		$user->save();
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
