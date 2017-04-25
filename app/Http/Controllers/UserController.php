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
	*　新しいコントローラーのインスタンスを作成する。
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('contentcare', ['only' => 'load']);
	}

    /**
     * Load data from database.
     *　データベースからデータをロードする。
     *
     * @param Request $request
     * @param integer $lessonNo
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */	
    public function load()
    {
		// Dummy course and lesson
        // コースとレッスンをダミーする。
    	$user_id= Auth::id();

		// Load data from Database
        // データベースからデータを出す。
    	$userData = User::where('id', '=', $user_id)->get()->toArray();
    	$roleData = Role::get();
    	for ($i=0; $i <count($roleData) ; $i++) { 
    		if ($roleData[$i]->id == $userData[0]['role']) {
    			$userData[0]['roleTitle'] = $roleData[$i]->role_title;
    		}
    	}
    	$countries = $this->countries;
    	return view("info", compact(['userData', 'countries']));
    }

    /**
     * Return new records of users
     * 新しいユーザーの記録をリターンする。
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
    			dd(count($users));
    			for ($i=0; $i < count($users); $i++) { 
    				$value = $users[$i];
    				$disk = \Storage::disk('s3-hidden');
    				if ($disk->exists($value))
    				{
    					$command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
    						'Bucket' => \Config::get('filesystems.disks.s3-hidden.bucket'),
    						'Key' => $value->cv,
    						'ResponseContentDisposition' => 'attachment;'
		    				//for download
    						]);

    					$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes');
		    				//$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, ‘+15 seconds’);

    					$generate_url = $request->getUri();
    					dd($generate_url);
    				}
    			}

    			return view('userList.applicants', ['users' => $users])->render();

    		} else {

    			return view('userList.normal', ['users' => $users])->render();

    		}
    	}

    	return view('userList.index', compact(['users']));
    }

	/**
	 * Update user's role
	 * ユーザーの役割を更新する。
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
	 * ユーザーの情報を編集することを行う。
	 * 
	 * @param  Request     $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function edit(Request $request)
	{
		// Load data from database.
		//データベースからデータをロードする。
		$user_id= Auth::id();
		$userData = User::find($user_id);

		$todayDate = date("Y/m/d");

		Validator::extend('18yo', function ($attribute, $value, $parameters, $validator) {
			return strtotime($value) <= strtotime('-18 years');
		});

		Validator::extend('validCountry', function ($attribute, $value, $parameters, $validator) {
			return array_key_exists($value, $this->countries);
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
			'country' => 'validCountry',
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
	 *　ユーザーのアバターを更新する。　
	 *
	 * @param  Request    $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function editAvatar(Request $request)
	{
		Validator::make($request->all(), [
			'avatar' => 'file|image|mimes:jpeg,png|dimensions:max_width=2000,max_height=2000|max:1024',
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
	 * Update user's password
	 * ユーザーのパスワードを更新する。
	 * 
	 * @param  Request     $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changePassword(Request $request)
	{
		Validator::extend('authenticated', function ($attribute, $value, $parameters, $validator) {
			return \Hash::check($value['oldPassword'], \Auth::user()->password);
		});

		Validator::extend('differentpass', function ($attribute, $value, $parameters, $validator) {
			return strcmp($value['oldPassword'], $value['newPassword']) == 0 ? false : true;
		});

		Validator::extend('confirm', function ($attribute, $value, $parameters, $validator) {
			return strcmp($value['password_confirm'], $value['newPassword']) == 0 ? true : false;
		});

		Validator::make($request->all(), [
			'pass' => 'authenticated|differentpass|confirm',
			'pass.newPassword' => 'required|min:6|max:24',
			],
			[
			'authenticated' => 'Your entered current password didn\'t match our record',
			'differentpass' => 'Your new password is the same as the current one',
			'required' => 'New password required',
			'min' => 'Password must be at minimum of :min characters',
			'max' => 'Password must be at maxium of :max characters',
			'confirm' => 'Your password confirmation does not match',
			])->validate();

		$user = \Auth::user();
		$user->password = \Hash::make($request->pass['newPassword']);
		$user->save();

		$request->session()->flash('alert-success', 'Your password has been successfully changed');
		return back();
	}

	protected $countries = [
	'AF' => 'Afghanistan',
	'AX' => 'Aland Islands',
	'AL' => 'Albania',
	'DZ' => 'Algeria',
	'AS' => 'American Samoa',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AQ' => 'Antarctica',
	'AG' => 'Antigua and Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas the',
	'BH' => 'Bahrain',
	'BD' => 'Bangladesh',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia and Herzegovina',
	'BW' => 'Botswana',
	'BV' => 'Bouvet Island (Bouvetoya)',
	'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
	'VG' => 'British Virgin Islands',
	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'CN' => 'China',
	'CX' => 'Christmas Island',
	'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',
	'KM' => 'Comoros the',
	'CD' => 'Congo',
	'CG' => 'Congo the',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote d\'Ivoire',
	'HR' => 'Croatia',
	'CU' => 'Cuba',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FO' => 'Faroe Islands',
	'FK' => 'Falkland Islands (Malvinas)',
	'FJ' => 'Fiji the Fiji Islands',
	'FI' => 'Finland',
	'FR' => 'France, French Republic',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'TF' => 'French Southern Territories',
	'GA' => 'Gabon',
	'GM' => 'Gambia the',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GH' => 'Ghana',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GU' => 'Guam',
	'GT' => 'Guatemala',
	'GG' => 'Guernsey',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HT' => 'Haiti',
	'HM' => 'Heard Island and McDonald Islands',
	'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IR' => 'Iran',
	'IQ' => 'Iraq',
	'IE' => 'Ireland',
	'IM' => 'Isle of Man',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JE' => 'Jersey',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KP' => 'Korea',
	'KR' => 'Korea',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyz Republic',
	'LA' => 'Lao',
	'LV' => 'Latvia',
	'LB' => 'Lebanon',
	'LS' => 'Lesotho',
	'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MO' => 'Macao',
	'MK' => 'Macedonia',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia',
	'MD' => 'Moldova',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'ME' => 'Montenegro',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'MM' => 'Myanmar',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'AN' => 'Netherlands Antilles',
	'NL' => 'Netherlands the',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PK' => 'Pakistan',
	'PW' => 'Palau',
	'PS' => 'Palestinian Territory',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn Islands',
	'PL' => 'Poland',
	'PT' => 'Portugal, Portuguese Republic',
	'PR' => 'Puerto Rico',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russian Federation',
	'RW' => 'Rwanda',
	'BL' => 'Saint Barthelemy',
	'SH' => 'Saint Helena',
	'KN' => 'Saint Kitts and Nevis',
	'LC' => 'Saint Lucia',
	'MF' => 'Saint Martin',
	'PM' => 'Saint Pierre and Miquelon',
	'VC' => 'Saint Vincent and the Grenadines',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome and Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'RS' => 'Serbia',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia (Slovak Republic)',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia, Somali Republic',
	'ZA' => 'South Africa',
	'GS' => 'South Georgia and the South Sandwich Islands',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SD' => 'Sudan',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard & Jan Mayen Islands',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland, Swiss Confederation',
	'SY' => 'Syrian Arab Republic',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania',
	'TH' => 'Thailand',
	'TL' => 'Timor-Leste',
	'TG' => 'Togo',
	'TK' => 'Tokelau',
	'TO' => 'Tonga',
	'TT' => 'Trinidad and Tobago',
	'TN' => 'Tunisia',
	'TR' => 'Turkey',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks and Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'US' => 'United States of America',
	'UM' => 'United States Minor Outlying Islands',
	'VI' => 'United States Virgin Islands',
	'UY' => 'Uruguay, Eastern Republic of',
	'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',
	'VE' => 'Venezuela',
	'VN' => 'Vietnam',
	'WF' => 'Wallis and Futuna',
	'EH' => 'Western Sahara',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe'
	];
}
