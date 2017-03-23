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
                            $preAct = false;
                            return;
                        }else{
                            $preAct = $lessonAct[$i-1];
                        }

                        if ($i == count($lessonAct)-1) {
                            $nextAct->link = "";
                            $nextAct->name = "Homepage";

                        }else{
                            $nextAct->link = "lesson".$lessonNo."/".$lessonAct[$i+1]->name;
                            $nextAct->name = $lessonAct[$i+1]->name;
                        }
                    }
                } 
                $request->attributes->add(['preAct' => $preAct, 'nextAct' => $nextAct]);
            }
            return $next($request);
        }
    }
}
