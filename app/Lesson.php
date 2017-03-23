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
    public function p1()
    {
        return $this->hasMany('App\P1_WordMemorize');
    }

    /**
     * Get the P2Element belongs to the lesson.
     */
    public function p2()
    {
        return $this->hasMany('App\P2_WordRecognize');
    }

    /**
     * Get the P3Element belongs to the lesson.
     */
    public function p3()
    {
        return $this->hasMany('App\P3_SentenceMemorize');
    }

    /**
     * Get the P4Element belongs to the lesson.
     */
    public function p4()
    {
        return $this->hasMany('App\P4_SentenceRecognize');
    }

    /**
     * Get the P5Element belongs to the lesson.
     */
    public function p5()
    {
        return $this->hasMany('App\P5_DialogueMemorize');
    }

    /**
     * Get the P6Element belongs to the lesson.
     */
    public function p6()
    {
        return $this->hasMany('App\P6_DialogueMultipleChoice');
    }

    /**
     * Get the P7Element belongs to the lesson.
     */
    public function p7()
    {
        return $this->hasMany('App\P7_ConversationMemorize');
    }

    /**
     * Get the P8Element belongs to the lesson.
     */
    public function p8()
    {
        return $this->hasMany('App\P8_ConversationFillWord');
    }

    /**
     * Get the P9Element belongs to the lesson.
     */
    public function p9()
    {
        return $this->hasMany('App\P9_ConversationFillSentence');
    }

    /**
     * Get the P10Element belongs to the lesson.
     */
    public function p10()
    {
        return $this->hasMany('App\P10_SentenceReorder');
    }

    /**
     * Get the P11Element belongs to the lesson.
     */
    public function p11()
    {
        return $this->hasMany('App\P11_ConversationReorder');
    }

    /**
     * Get the P12Element belongs to the lesson.
     */
    public function p12()
    {
        return $this->hasOne('App\P12_GroupInteraction');
    }

    /**
     * Get the P13Element belongs to the lesson.
     */
    public function p13()
    {
        return $this->hasOne('App\P13_Text');
    }

    /**
     * Get the P14Element belongs to the lesson.
     */
    public function p14()
    {
        return $this->hasMany('App\P14_SentencePattern');
    }

    /**
     * Get the Extensions belongs to the lesson.
     */
    public function extensions()
    {
        return $this->hasMany('App\Extension');
    }
}
