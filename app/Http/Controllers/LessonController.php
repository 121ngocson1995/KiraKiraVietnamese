<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Lesson;
use App\Situation;
use App\P1WordMemorize;

class LessonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'getLesson']);
    }

	public static function getLesson($lessonNo, $course_id = 1)
	{
		// \DB::listen(function($query) {
		// 	dd($query->sql);
		// });
		$lesson = Lesson::where('lessonNo', '=', $lessonNo)->first();
		return $lesson;
	}

	public function preAdd()
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db

		$courseData = Course::where('id', '=', $course_id)->get();
		$lessonData = Lesson::where('course_id', '=', $course_id)->get();
		$lessonCnt = count($lessonData);
		for ($i=0; $i<$lessonCnt; $i++){
			$lessonList[$i]['lessonNo'] = $lessonData[$i]->lessonNo;
			$lessonList[$i]['lessonName'] = $lessonData[$i]->lesson_name;
		}

		return view('addLesson', compact('lessonList'));
	}

	public function add(Request $request)
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$lessonNew = new Lesson;
		$lessonNew->course_id = $course_id;
		$lessonNew->lessonNo = $request->all()['lsnNo'];
		$lessonNew->lesson_name = $request->all()['lsnName'];
		$lessonNew->description = $request->all()['description'];
		$lessonNew->author = $request->all()['lsnAuthor'];
		$lessonNew->added_by = Auth::id();
		$lessonNew->last_updated_by = Auth::id();
		$lessonNew->save();
		return redirect('/');
	}

	public function listLesson()
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$lessonData = Lesson::where('course_id', '=', $course_id)->get();

		return view('listLesson', compact('lessonData'));
	}

	public function delete($lessonNo) 
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$courseData = Course::where('id', '=', $course_id)->get();
		$lessonData = Lesson::where('course_id', '=', $course_id)->where('lessonNo', '=', $lessonNo)->delete();

		return redirect('/listLesson');
	}

	public function preEdit($lessonNo)
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$courseData = Course::where('id', '=', $course_id)->get();
		$lessonData = Lesson::where('course_id', '=', $course_id)->where('lessonNo', '=', $lessonNo)->get();

		return view('editLesson', compact('lessonData'));
	}

	public function edit(Request $request)
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$lessonEdit = Lesson::where('course_id', '=', $course_id)->find($request->all()['lesson_id']);
		$lessonEdit->course_id = $course_id;
		$lessonEdit->lessonNo = $request->all()['lsnNo'];
		$lessonEdit->lesson_name = $request->all()['lsnName'];
		$lessonEdit->description = $request->all()['description'];
		$lessonEdit->author = $request->all()['lsnAuthor'];
		$lessonEdit->last_updated_by = Auth::id();
		$lessonEdit->save();
		$lessonData = Lesson::where('course_id', '=', $course_id)->where('lessonNo', '=', $lessonNo)->get();

		return view('editLesson', compact('lessonData'));
	} 

	public function listAct($lessonId)
	{
		$lesson = Lesson::find($lessonId);
		$activity = [];

		$practiceNo = 0;

		if ($lesson->situations()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'situations';
			$currentActivity->content = 'Situations';
			$activity[] = $currentActivity;
		}

		if ($lesson->p1()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p1';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to words and repeat';
			$activity[] = $currentActivity;
		}

		if ($lesson->p2()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p2';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen and find the correct words';
			$activity[] = $currentActivity;
		}

		if ($lesson->p3()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p3';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to sentences and repeat';
			$activity[] = $currentActivity;
		}

		if ($lesson->p4()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p4';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen and find the correct sentences';
			$activity[] = $currentActivity;
		}

		if ($lesson->p5()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p5';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to dialogues and repeat';
			$activity[] = $currentActivity;
		}

		if ($lesson->p6()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p6';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Choose the correct answer';
			$activity[] = $currentActivity;
		}

		if ($lesson->p7()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p7';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Practice speaking after dialogues';
			$activity[] = $currentActivity;
		}

		if ($lesson->p8()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p8';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Fill in the blanks';
			$activity[] = $currentActivity;
		}

		if ($lesson->p9()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p9';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Complete the dialogues';
			$activity[] = $currentActivity;
		}

		if ($lesson->p10()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p10';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Arrange words in correct order';
			$activity[] = $currentActivity;
		}

		if ($lesson->p11()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p11';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Arrange sentences in correct order';
			$activity[] = $currentActivity;
		}

		if ($lesson->p12()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p12';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Group activity';
			$activity[] = $currentActivity;
		}

		if ($lesson->p13()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p13';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Texts';
			$activity[] = $currentActivity;
		}

		if ($lesson->p14()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'p14';
			$currentActivity->content = 'Practice ' . ++$practiceNo . ': Learn by heart the grammars';
			$activity[] = $currentActivity;
		}

		if ($lesson->languageCultures()->exists()) {
			$currentActivity = new \stdClass;
			$currentActivity->name = 'extensions';
			$currentActivity->content = 'Language and Culture';
			$activity[] = $currentActivity;
		}
		$lesson->activity = $activity;
		return view('listAct', compact('lesson'));
	}

	public function preEditAct($lessonId, $activityName)
	{
    	// dummy course và lesson
		$course_id= 1;

    	// Lấy dữ liệu từ db
		$lessonEdit = Lesson::where('course_id', '=', $course_id)->find($lessonId);
		switch ($activityName) {
			case 'situations':
			$situation = Situation::where('lesson_id', '=', $lessonId)->get();
			for ($i=0; $i<count($situation); $i++){
				$situation[$i]->dialogArr = str_replace( "|","\n", $situation[$i]->dialog);
				$situation[$i]->dialogTransArr = str_replace( "|","\n", $situation[$i]->dialog_translate);
			}
			return view('editSitu', compact(['situation', 'lessonId']));
			break;

			case 'p1':
			$p1 = P1WordMemorize::where('lesson_id', '=', $lessonId)->get();
			return view('editP1', compact(['p1', 'lessonId']));
			break;
			
			default:
			return redirect('/');
			break;
		}
	} 
}
