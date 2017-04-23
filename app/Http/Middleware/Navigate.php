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
        // dd($activity);
        for ($i=0; $i < count($lessons); $i++) {
            if ($lessons[$i]->lessonNo == $lessonNo) {
                $lessonAct = $lessons[$i]->activity;
                $checkExist = true;
            }
            if ($checkExist) {
                for ($j=0; $j < count($lessonAct); $j++) {
                    if ($lessonAct[$j]->name == $activity) {
                        if ($j == 0) {
                            $preAct->link = "lessons";
                            $preAct->name = "View all lessons";
                        } else if ($j > 0 && strcmp($lessonAct[$j-1]->name, "situations") == 0) {
                            $preAct->link = "lesson".$lessonNo."/".$lessonAct[$j-1]->name;
                            $preAct->name = "Situations";
                        } else {
                            $preAct->link = "lesson".$lessonNo."/".$lessonAct[$j-1]->name;
                            $preAct->name = $lessonAct[$j-1]->name;
                        }

                        if ($j == count($lessonAct)-1) {
                            $nextAct->link = "lessons";
                            $nextAct->name = "View all lessons";
                        } else if ($j < count($lessonAct)-1 && strcmp($lessonAct[$j+1]->name, "extensions") == 0) {
                            $nextAct->link = "lesson".$lessonNo."/".$lessonAct[$j+1]->name;
                            $nextAct->name = "Language and Culture";
                        } else {
                            $nextAct->link = "lesson".$lessonNo."/".$lessonAct[$j+1]->name;
                            $nextAct->name = $lessonAct[$j+1]->name;
                        }
                    }
                }
                $request->attributes->add(['preAct' => $preAct, 'nextAct' => $nextAct]);
            }
        }
        return $next($request);
    }
}
