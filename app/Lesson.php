<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
	 * Get the administrator that added the lesson.
	 */
	public function administrator_added()
	{
	    return $this->belongsTo('App\Administrator', 'added_by');
	}

    /**
	 * Get the administrator that last updated the lesson.
	 */
	public function administrator_last_updated()
	{
	    return $this->belongsTo('App\Administrator', 'last_updated_by');
	}


    /**
     * Get the situations belongs to the lesson.
     */
    public function situations()
    {
        return $this->hasMany('App\Situation');
    }

    /**
     * Get the P1Element belongs to the lesson.
     */
    public function p1elements()
    {
        return $this->hasMany('App\P1Element');
    }

    /**
     * Get the P2Element belongs to the lesson.
     */
    public function p2elements()
    {
        return $this->hasMany('App\P2Element');
    }

    /**
     * Get the P3Element belongs to the lesson.
     */
    public function p3elements()
    {
        return $this->hasMany('App\P3Element');
    }

    /**
     * Get the P4Element belongs to the lesson.
     */
    public function p4elements()
    {
        return $this->hasMany('App\P4Element');
    }

    /**
     * Get the P5Element belongs to the lesson.
     */
    public function p5elements()
    {
        return $this->hasMany('App\P5Element');
    }

    /**
     * Get the P6Element belongs to the lesson.
     */
    public function p6elements()
    {
        return $this->hasMany('App\P6Element');
    }

    /**
     * Get the P7Element belongs to the lesson.
     */
    public function p7elements()
    {
        return $this->hasMany('App\P7Element');
    }

    /**
     * Get the P8Element belongs to the lesson.
     */
    public function p8elements()
    {
        return $this->hasMany('App\P8Element');
    }

    /**
     * Get the P9Element belongs to the lesson.
     */
    public function p9elements()
    {
        return $this->hasMany('App\P9Element');
    }

    /**
     * Get the P10Element belongs to the lesson.
     */
    public function p10elements()
    {
        return $this->hasMany('App\P10Element');
    }

    /**
     * Get the P11Element belongs to the lesson.
     */
    public function p11elements()
    {
        return $this->hasMany('App\P11Element');
    }

    /**
     * Get the P12Element belongs to the lesson.
     */
    public function p12elements()
    {
        return $this->hasOne('App\P12Element');
    }

    /**
     * Get the P13Element belongs to the lesson.
     */
    public function p13elements()
    {
        return $this->hasOne('App\P13Element');
    }

    /**
     * Get the P14Element belongs to the lesson.
     */
    public function p14elements()
    {
        return $this->hasMany('App\P14Element');
    }

    /**
     * Get the Extensions belongs to the lesson.
     */
    public function extensions()
    {
        return $this->hasMany('App\Extension');
    }
}
