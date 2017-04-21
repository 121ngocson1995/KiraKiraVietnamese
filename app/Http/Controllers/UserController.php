<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

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

    /**
     * Load data from database.
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */	
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

    /**
     * Return new records of users
     * 
     * @param  Request  	$request
     * @param  string 		$type
     * @param  string 		$keyword
     * @param  string 		$pagination
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
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

    			$searchUsername = User::whereIn('role', $type)->where('username', 'like', $keyword)->latest('created_at');
    			$searchFirstname = User::whereIn('role', $type)->where('first_name', 'like', $keyword)->latest('created_at');
    			$searchLastname = User::whereIn('role', $type)->where('last_name', 'like', $keyword)->latest('created_at');
    			$searchEmail = User::whereIn('role', $type)->where('email', 'like', $keyword)->latest('created_at');

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

	/**
	 * Update user's role
	 * 
	 * @param  Request      $request
	 * @return void
	 */
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

	/**
	 * Perform editing user's information
	 * 
	 * @param  Request     $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
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

	/**
	 * Update user's avatar
	 * @param  Request    $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function editAvatar(Request $request)
	{
		Validator::make($request->all(), [
			'avatar' => 'file|image|mimes:jpg,png|dimensions:max_width=1000,max_height=1000|max:1024',
			],
			[
			'dimensions' => 'The maximum size of your avatar is :max_widthx:max_height pixels or 1mb',
			])->validate();

		$destinationPath = 'avatar'; 
		$extension = $request->avatar->extension();

		$fileName = "Avatar_" . \Auth::user()->id . "_" . $request->_token . '.' . $extension;

		$path = 'img/avatar';
		Input::file("avatar")->move($path, $fileName);
		
		\Auth::user()->avatar = $fileName;
		\Auth::user()->save();

		return back();
	}

	/**
	 * Update password
	 * 
	 * @param  Request     $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changePassword(Request $request)
	{
		$user = \Auth::user();
		Validator::extend('authenticated', function ($attribute, $value, $parameters, $validator) {
			return \Hash::check($value['oldPassword'], $user->password);
		});

		Validator::extend('differentPass', function ($attribute, $value, $parameters, $validator) {
			return strcmp($value['oldPassword'], $value['newPassword']) == 0 ? false : true;
		});

		Validator::extend('confirm', function ($attribute, $value, $parameters, $validator) {
			return strcmp($value['password_confirm'], $value['newPassword']) == 0 ? true : false;
		});

		Validator::make($request->all(), [
			'pass' => 'authenticated|differentPass',
			'pass.newPassword' => 'required|min:6|max:24',
			'pass' => 'confirm',
			],
			[
			'authenticated' => 'Your entered current password didn\'t match our record',
			'different_pass' => 'Your new password is the same as the current one',
			'required' => 'New password required',
			'min' => 'Password must be at minimumof :min characters',
			'max' => 'Password must be at maxium of :max characters',
			'confirm' => 'Your password confirmation does not math',
			])->validate();

		$user->password = \Hash::make($request->pass['newPassword']);
		$user->save();

		return back();
	}
}
