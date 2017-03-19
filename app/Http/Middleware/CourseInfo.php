<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;

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
        $lessons = json_decode(File::get(storage_path() . "/dummy/home.json"));
        
        /*
        ** Decide if there's any lesson or activity currently active
        */
        $lessonNo = false;
        $activity = false;
        $uri = explode('/', $request->path());

        if (count($uri) > 1 && strpos($uri[count($uri) - 2], 'lesson') === 0) {
            $lessonNo = $uri[count($uri) - 2];
        }
        if (count($uri) > 0 && (strpos($uri[count($uri) - 1], 'P') === 0 || strpos($uri[count($uri) - 1], 'Situation') === 0) ) {
            $activity = $uri[count($uri) - 1];
        }
        $request->attributes->add(['lessons' => $lessons, 'lessonNo' => $lessonNo, 'activity' => $activity]);
        return $next($request);
    }
}
