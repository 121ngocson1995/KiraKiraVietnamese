<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class P10SentenceReorder extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id', 'sentence', 'correctOrder',
    ];

    /**
	 * Get the parent lesson.
	 */
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
