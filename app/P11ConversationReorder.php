<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P11ConversationReorder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sentence', 'correctOrder',
    ];

    /**
	 * Get the parent lesson.
	 */
	public function lesson()
	{
	    return $this->belongsTo('App\Lesson');
	}
}
