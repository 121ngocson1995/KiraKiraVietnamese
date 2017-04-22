<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class P8ConversationFillWord extends Model
{
	use SoftDeletes;
    /**
	 * Get the parent lesson.
	 * 親レッスンを取る。
	 */
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
