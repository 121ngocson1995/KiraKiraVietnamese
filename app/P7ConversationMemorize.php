<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class P7ConversationMemorize extends Model
{
    /**
	 * Get the parent lesson.
	 * 親レッスンを取る。
	 */
    use SoftDeletes;
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
