<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageCulture extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *　割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id', 'extensionNo', 'type', 'title', 'content', 'thumbnail', 'audio', 'video', 'slideshow_caption', 'slideshow_images', 'song_composer', 'song_performer', 'riddle_answer'
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
