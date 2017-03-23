<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P8ConversationFillWord extends Model
{
    /**
	 * Get the parent lesson.
	 */
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}