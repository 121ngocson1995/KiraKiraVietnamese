<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;
use App\Lesson;

class CourseInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        ** Get course's lessons and activities for sidebar navigation
        */

        // $lessons = json_decode(File::get(storage_path() . "/dummy/home.json"));

        $allLessons = Lesson::where('course_id', '=', 1)->orderBy('lessonNo')->get();
        $lessons = [];
        $lessonsWithNo = [];
        foreach ($allLessons as $lesson) {
            $currentLesson = new \stdClass;
            $currentLesson->lessonNo = $lesson->lessonNo;
            $currentLesson->name = $lesson->lesson_name;
            $currentLesson->description = $lesson->description;
            $currentLesson->author = $lesson->author;

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

            $currentLesson->activity = $activity;
            $lessons[] = $currentLesson;

            $lessonsWithNo[(string) $currentLesson->lessonNo] = $currentLesson;
        }

        // dd($lessonsWithNo);
        
        /*
        ** Decide if there's any lesson or activity currently active
        */
        $lessonNo = false;
        $activity = false;
        $uri = explode('/', $request->path());

        if (count($uri) > 1 && strpos($uri[count($uri) - 2], 'lesson') === 0) {
            $lessonNo = $uri[count($uri) - 2];
        }
        if (count($uri) > 0 && (strpos($uri[count($uri) - 1], 'p') === 0 || strpos($uri[count($uri) - 1], 'situation') === 0 || strpos($uri[count($uri) - 1], 'extension') === 0) ) {
            $activity = $uri[count($uri) - 1];
        }
        $request->attributes->add(['lessons' => $lessons, 'lessonsWithNo' => $lessonsWithNo, 'lessonNo' => $lessonNo, 'activity' => $activity]);
        return $next($request);
    }
}
