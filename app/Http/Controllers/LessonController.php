<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Lesson;
use App\Situation;
use App\P1WordMemorize;
use App\P2WordRecognize;
use App\P3SentenceMemorize;
use App\P4SentenceRecognize;
use App\P5DialogueMemorize;
use App\P6DialogueMultipleChoice;
use App\P7ConversationMemorize;
use App\P10SentenceReorder;
use App\P11ConversationReorder;
use App\P12GroupInteraction;
use App\P13Text;
use App\P14SentencePattern;

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

    /**
     * Fetch the chosen lesson from database
     * 
     * @param  integer       $lesson
     * @param  integer       $course_id
     * @return Collection
     */ 
    public static function getLesson($lessonNo, $course_id = 1)
    {
    	$lesson = Lesson::where('lessonNo', '=', $lessonNo)->first();
    	return $lesson;
    }

    /**
     * Return "add lesson" screen
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
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

    /**
     * Perform inserting to database
     * 
     * @param Request   $request
     */
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

    /**
     * Return all lessons
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function listLesson()
    {
    	// dummy course và lesson
    	$course_id= 1;

    	// Lấy dữ liệu từ db
    	$lessonData = Lesson::where('course_id', '=', $course_id)->get();

    	return view('listLesson', compact('lessonData'));
    }

    /**
     * @param  integer  $lessonNo
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete($lessonNo) 
    {
    	// dummy course và lesson
    	$course_id= 1;

    	// Lấy dữ liệu từ db
    	$courseData = Course::where('id', '=', $course_id)->get();
    	$lessonData = Lesson::where('course_id', '=', $course_id)->where('lessonNo', '=', $lessonNo)->delete();

    	return redirect('/listLesson');
    }

    /**
     * Return lesson's information for editing
     * 
     * @param  integer      $lessonNo
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function preEdit($lessonNo)
    {
    	// dummy course và lesson
    	$course_id= 1;

    	// Lấy dữ liệu từ db
    	$courseData = Course::where('id', '=', $course_id)->get();
    	$lessonData = Lesson::where('course_id', '=', $course_id)->where('lessonNo', '=', $lessonNo)->get();

    	return view('editLesson', compact('lessonData'));
    }

    /**
     * Perform updating lesson
     * 
     * @param  Request      $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
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

    /**
     * Return a list of the chosen lesson's activities
     * 
     * @param  integer      $lessonid
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function listAct($lessonId)
    {
    	$lesson = Lesson::find($lessonId);
    	$activity = [];

    	$practiceNo = 0;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'situations';
    	$currentActivity->content = 'Situations';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p1';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to words and repeat';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p2';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen and find the correct words';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p3';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to sentences and repeat';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p4';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen and find the correct sentences';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p5';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Listen to dialogues and repeat';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p6';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Choose the correct answer';
    	$activity[] = $currentActivity;
    	
    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p7';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Practice speaking after dialogues';
    	$activity[] = $currentActivity;
    	
    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p8';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Fill in the blanks';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p9';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Complete the dialogues';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p10';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Arrange words in correct order';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p11';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Arrange sentences in correct order';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p12';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Group activity';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p13';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Texts';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'p14';
    	$currentActivity->content = 'Practice ' . ++$practiceNo . ': Learn by heart the grammars';
    	$activity[] = $currentActivity;

    	$currentActivity = new \stdClass;
    	$currentActivity->name = 'extensions';
    	$currentActivity->content = 'Language and Culture';
    	$activity[] = $currentActivity;
    	$lesson->activity = $activity;
    	return view('listAct', compact('lesson'));
    }

    /**
     * Return "edit activity" screen
     * 
     * @param  integer      $lessonId
     * @param  string       $activityName
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
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

    		case 'p2':
    		$p2 = P2WordRecognize::where('lesson_id', '=', $lessonId)->get();
    		return view('editP2', compact(['p2', 'lessonId']));
    		break;

    		case 'p3':
    		$p3 = P3SentenceMemorize::where('lesson_id', '=', $lessonId)->get();
    		return view('editP3', compact(['p3', 'lessonId']));
    		break;

    		case 'p4':
    		$p4 = P4SentenceRecognize::where('lesson_id', '=', $lessonId)->get();
    		return view('editP4', compact(['p4', 'lessonId']));
    		break;

    		case 'p5':
    		$p5 = P5DialogueMemorize::where('lesson_id', '=', $lessonId)->get();
    		for ($i=0; $i<count($p5); $i++){
    			$p5[$i]->dialogArr = str_replace( "|","\n", $p5[$i]->dialog);
    		}
    		return view('editP5', compact(['p5', 'lessonId']));
    		break;

    		case 'p6':
    		$p6 = P6DialogueMultipleChoice::where('lesson_id', '=', $lessonId)->orderBy('dialogNo')->get();

    		return view('manage.editP6', compact(['p6', 'lessonId']));
    		break;

    		case 'p7':
    		$p7 = P7ConversationMemorize::where('lesson_id', '=', $lessonId)->orderBy('dialogNo')->get();
    		$dialogCnt = array();
    		$contentArr = array();
    		for ($i=0; $i<count($p7); $i++){
    			$dup = false;
    			for ($j=0; $j < count($dialogCnt) ; $j++) { 
    				if($p7[$i]->dialogNo == $dialogCnt[$j]){
    					$dup = true;
    				}
    			}
    			if ($dup == false) {
    				array_push($dialogCnt, $p7[$i]->dialogNo);
    			}
    		}
    		for ($i=0; $i<count($dialogCnt); $i++){
    			for ($j=0; $j < count($p7) ; $j++) { 
    				if ($p7[$j]['dialogNo'] == $dialogCnt[$i]) {
    					$line = explode('|', $p7[$j]['dialogue']);
    					for ($k=0; $k < count($line)  ; $k++) { 
    						$line[$k] = explode('*', $line[$k]);
    					}
    					array_push($contentArr, $line);
    				}
    			}
    		}
    		return view('editP7', compact(['p7', 'contentArr', 'lessonId']));
    		break;

    		case 'p8':
    		$p8 = P8ConversationFillWord::where('lesson_id', '=', $lesson_id)->orderBy('dialogNo')->get();
    		$dialogCnt = array();

    		for ($i=0; $i< count($p8); $i++){
    			$dup = false;
    			for ($j=0; $j < count($dialogCnt) ; $j++) { 
    				if($p8[$i]->dialogNo == $dialogCnt[$j]){
    					$dup = true;
    				}
    			}
    			if ($dup == false) {
    				array_push($dialogCnt, $p8[$i]->dialogNo);
    			}

    			$p8[$i]->answer = explode(',', $p8[$i]->answer);
    		}
    		return view('editP8', compact(['p8', 'dialogCnt', 'lessonId']));
    		break;

    		case 'p10':
    		$p10 = P10SentenceReorder::where('lesson_id', '=', $lessonId)->orderBy('sentenceNo')->orderBy('correctOrder')->get();

    		$p10Element = array();

    		foreach ($p10 as $element) {
    			if(!array_key_exists($element->sentenceNo, $p10Element)) {
    				$p10Element[$element->sentenceNo] = array();
    			}

    			$p10Element[$element->sentenceNo][] = $element;
    		}

    		return view('manage.editP10', compact(['p10Element', 'lessonId']));
    		break;

    		case 'p11':
    		$p11 = P11ConversationReorder::where('lesson_id', '=', $lessonId)->orderBy('id')->get();

            return view('manage.editP11', compact(['p11', 'lessonId']));
            break;

            case 'p12':
            $p12 = P12GroupInteraction::where('lesson_id', '=', $lessonId)->orderBy('id')->get();

            return view('manage.editP12', compact(['p12', 'lessonId']));
            break;

            case 'p13':
            $p13 = P13Text::where('lesson_id', '=', $lessonId)->orderBy('id')->get();

            return view('manage.editP13', compact(['p13', 'lessonId']));
            break;

			case 'p14':
			$p14 = P14SentencePattern::where('lesson_id', '=', $lessonId)->orderBy('id')->get();

    		for ($pId = 0; $pId < count($p14); $pId++) {
    			$sentence = $p14[$pId]->sentence;
    			$sentencePart = explode('*', $sentence);
    			$sentenceParts = array();

    			for ($i=0; $i < count($sentencePart); $i++) { 
    				if(empty($sentencePart[$i])) {
    					array_splice($sentencePart, $i, $i+1);
    					$i--;
    					continue;
    				}

    				$partOption = explode('|', $sentencePart[$i]);
    				$sentenceParts[] = $partOption;
    			}

    			$p14[$pId]->sentenceParts = $sentenceParts;
    		}
    		return view('manage.editP14', compact(['p14', 'lessonId']));
    		break;

    		default:
    		return redirect('/');
    		break;
    	}
    } 
}
