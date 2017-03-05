<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
	 * Get the administrator that added the course.
	 */
	public function administrator_added()
	{
	    return $this->belongsTo('App\Administrator', 'added_by');
	}

    /**
	 * Get the administrator that last updated the course.
	 */
	public function administrator_last_updated()
	{
	    return $this->belongsTo('App\Administrator', 'last_updated_by');
	}

    /**
     * Get the lessons belongs to the course.
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
}
