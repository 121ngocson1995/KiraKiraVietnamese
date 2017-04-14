<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Request;
use Session;
class ApplyController extends Controller {
	public function upload() {
  		// getting all of the post data
		$file = array('image' => Input::file('image1'));
  		// setting up rules
  		dd($file);
		$rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
  		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
  		// send back to the page with the input data and errors
			return Redirect::to('upload')->withInput()->withErrors($validator);
		}
		else {
		// checking file is valid.
			if (Input::file('image1')->isValid()) {
      			$destinationPath = 'uploads'; // upload path
      			$extension = Input::file('image1')->getClientOriginalExtension(); // getting image extension
      			$fileName = rand(11111,99999).'.'.$extension; // renameing image
      			Input::file('image1')->move($destinationPath, $fileName); // uploading file to given path
			      // sending back with message
      			Session::flash('success',  $path); 
      			return Redirect::to('upload');
      		}
      		else {
     		// sending back with error message.
      			Session::flash('error', 'uploaded file is not valid');
      			return Redirect::to('upload');
      		}
      	}
      }
  }