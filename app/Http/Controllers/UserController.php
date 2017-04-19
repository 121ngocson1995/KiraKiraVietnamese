<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;

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

	public function index(Request $request, $type='%', $keyword='%', $pagination=5)
	{
		$users = User::latest('created_at')->paginate($pagination);

		if($request->ajax()) {
			if (strcmp($request->input('type'), 'pending') == 0) {
				$type = array(1);
			} else if (strcmp($request->input('type'), 'rejected') == 0) {
				$type = array(0);
			} else if (strcmp($request->input('type'), 'admins') == 0) {
				$type = array(10, 100);
			} else if (strcmp($request->input('type'), 'teachers') == 0) {
				$type = array(3);
			} else if (strcmp($request->input('type'), 'learners') == 0) {
				$type = array(2);
			} else {
				$type = Role::all()->pluck('id')->toArray();
			}

			$users;
			if (!$request->has('keyword')) {
				$users = User::whereIn('role', $type)->latest('created_at')->paginate($pagination);
			} else {
				$keyword = '%' . $request->keyword . '%';

				$searchEmail = User::whereIn('role', $type)->where('email', 'like', $keyword)->latest('created_at');
				$searchLastname = User::whereIn('role', $type)->where('last_name', 'like', $keyword)->latest('created_at');
				$searchFirstname = User::whereIn('role', $type)->where('first_name', 'like', $keyword)->latest('created_at');
				$searchUsername = User::whereIn('role', $type)->where('username', 'like', $keyword)->latest('created_at');

				$query = $searchUsername->union($searchFirstname)->union($searchLastname)->union($searchEmail);
				
				$userList = $query->get();
				$count = $userList->count();
				$slice = $userList->slice($pagination * ((integer)($request->page) - 1), $pagination);
				
				// $userList = $query->skip($pagination * ((integer)($request->page) - 1))->take($pagination)->get();

				$users = new LengthAwarePaginator($slice, $count, $pagination, null, [
					'path' => $request->path,
					]);
			}

			// dd(User::whereIn('role', $type)->where(function($query) {
			// 	$query->where('username', 'like', $keyword)
			// 		  ->orWhere('email', 'like', $keyword)
			// 		  ->orWhere('email', 'like', $keyword)
			// 		  ->orWhere('email', 'like', $keyword);
			// }->latest('created_at')->toSql());
			
			if (strcmp($request->input('type'), 'pending') == 0 || strcmp($request->input('type'), 'rejected') == 0) {

				return view('userList.applicants', ['users' => $users])->render();

			} else {

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
		$userData->save();

		return redirect("/userManage");
	}
}
