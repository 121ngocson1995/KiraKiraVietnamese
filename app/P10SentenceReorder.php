<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class P10SentenceReorder extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *　割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id', 'sentenceNo', 'word', 'correctOrder',
    ];

    /**
	 * Get the parent lesson.
     * 親レッスンを取る。
	 */
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
