<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    /**
	 * Get the user that owns the phone.
	 */
	public function user()
	{
	    return $this->belongsTo('App\User');
	}

    /**
     * Get the courses added by the administrator.
     */
    public function added_courses()
    {
        return $this->hasMany('App\Course', 'added_by');
    }

    /**
     * Get the courses last updated by the administrator.
     */
    public function updated_courses()
    {
        return $this->hasMany('App\Course', 'last_updated_by');
    }

    /**
     * Get the lessons added by the administrator.
     */
    public function added_lessons()
    {
        return $this->hasMany('App\Lesson', 'added_by');
    }

    /**
     * Get the lessons last updated by the administrator.
     */
    public function updated_lessons()
    {
        return $this->hasMany('App\Lesson', 'last_updated_by');
    }
}
