<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class P4SentenceRecognize extends Model
{
    /**
	 * Get the parent lesson.
	 */
    use SoftDeletes;
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
