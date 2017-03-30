<?php

namespace App\Http\Middleware;

use Closure;

class Navigate
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
        $lessons = $request->get('lessons');
        $lessonNo = substr_replace($request->get('lessonNo'),"", 0, 6);
        $activity = $request->get('activity');
        $checkExist = false;
        $lessonAct;
        $preAct = new \stdClass;
        $nextAct = new \stdClass;

        for ($i=0; $i < count($lessons); $i++) {
            if ($lessons[$i]->lessonNo == $lessonNo) {
                $lessonAct = $lessons[$i]->activity;
                $checkExist = true;
            }
            if ($checkExist) {
                for ($i=0; $i < count($lessonAct); $i++) {
                    if ($lessonAct[$i]->name == $activity) {
                        if ($i == 0) {
                            $preAct->link = "lessons";
                            $preAct->name = "View all lessons";
                        } else if ($i > 0 && strcmp($lessonAct[$i-1]->name, "situations") == 0) {
                            $preAct->link = "lesson".$lessonNo."/".$lessonAct[$i-1]->name;
                            $preAct->name = "Situations";
                        } else {
                            $preAct->link = "lesson".$lessonNo."/".$lessonAct[$i-1]->name;
                            $preAct->name = $lessonAct[$i-1]->name;
                        }

                        if ($i == count($lessonAct)-1) {
                            $nextAct->link = "lessons";
                            $nextAct->name = "View all lessons";
                        } else if ($i < count($lessonAct)-1 && strcmp($lessonAct[$i+1]->name, "extensions") == 0) {
                            $nextAct->link = "lesson".$lessonNo."/".$lessonAct[$i+1]->name;
                            $nextAct->name = "Language and Culture";
                        } else {
                            $nextAct->link = "lesson".$lessonNo."/".$lessonAct[$i+1]->name;
                            $nextAct->name = $lessonAct[$i+1]->name;
                        }
                    }
                }
                $request->attributes->add(['preAct' => $preAct, 'nextAct' => $nextAct]);
            }
        }
        return $next($request);
    }
}
