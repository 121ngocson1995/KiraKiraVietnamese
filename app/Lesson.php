<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *　割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'lessonNo', 'lesson_name', 'description', 'author', 'added_by', 'last_updated_by',
    ];

    /**
	 * Get the administrator that added the lesson.
     * レッスンを追加した管理者を取る。
	 */
	public function administrator_added()
	{
	    return $this->belongsTo('App\User', 'added_by');
	}

    /**
	 * Get the administrator that last updated the lesson.
     * レッスンを最終更新した管理者を取る。
	 */
	public function administrator_last_updated()
	{
	    return $this->belongsTo('App\User', 'last_updated_by');
	}


    /**
     * Get the situations belongs to the lesson.
    　*　レッスンンに属する「situations」を取る。
     */
    public function situations()
    {
        return $this->hasMany('App\Situation');
    }

    /**
     * Get the P1Element belongs to the lesson.
     *　レッスンンに属する「P1Element」を取る。
     */
    public function p1()
    {
        return $this->hasMany('App\P1WordMemorize');
    }

    /**
     * Get the P2Element belongs to the lesson.
    　*　レッスンンに属する「P2Element」を取る。
     */
    public function p2()
    {
        return $this->hasMany('App\P2WordRecognize');
    }

    /**
     * Get the P3Element belongs to the lesson.
     *　レッスンンに属する「P3Element」を取る。
     */
    public function p3()
    {
        return $this->hasMany('App\P3SentenceMemorize');
    }

    /**
     * Get the P4Element belongs to the lesson.
     *　レッスンンに属する「P4Element」を取る。
     */
    public function p4()
    {
        return $this->hasMany('App\P4SentenceRecognize');
    }

    /**
     * Get the P5Element belongs to the lesson.
     *　レッスンンに属する「P5Element」を取る。
     */
    public function p5()
    {
        return $this->hasMany('App\P5DialogueMemorize');
    }

    /**
     * Get the P6Element belongs to the lesson.
     *　レッスンンに属する「P6Element」を取る。
     */
    public function p6()
    {
        return $this->hasMany('App\P6DialogueMultipleChoice');
    }

    /**
     * Get the P7Element belongs to the lesson.
     *　レッスンンに属する「P7Element」を取る。
     */
    public function p7()
    {
        return $this->hasMany('App\P7ConversationMemorize');
    }

    /**
     * Get the P8Element belongs to the lesson.
     *　レッスンンに属する「P8Element」を取る。
     */
    public function p8()
    {
        return $this->hasMany('App\P8ConversationFillWord');
    }

    /**
     * Get the P9Element belongs to the lesson.
     *　レッスンンに属する「P9Element」を取る。
     */
    public function p9()
    {
        return $this->hasMany('App\P9ConversationFillSentence');
    }

    /**
     * Get the P10Element belongs to the lesson.
     *　レッスンンに属する「P10Element」を取る。
     */
    public function p10()
    {
        return $this->hasMany('App\P10SentenceReorder');
    }

    /**
     * Get the P11Element belongs to the lesson.
     *　レッスンンに属する「P11Element」を取る。
     */
    public function p11()
    {
        return $this->hasMany('App\P11ConversationReorder');
    }

    /**
     * Get the P12Element belongs to the lesson.
     *　レッスンンに属する「P12Element」を取る。
     */
    public function p12()
    {
        return $this->hasOne('App\P12GroupInteraction');
    }

    /**
     * Get the P13Element belongs to the lesson.
     *　レッスンンに属する「P13Element」を取る。
     */
    public function p13()
    {
        return $this->hasOne('App\P13Text');
    }

    /**
     * Get the P14Element belongs to the lesson.
     *　レッスンンに属する「P14Element」を取る。
     */
    public function p14()
    {
        return $this->hasMany('App\P14SentencePattern');
    }

    /**
     * Get the Extensions belongs to the lesson.
     *　レッスンンに属する「Extensions」を取る。
     */
    public function languageCultures()
    {
        return $this->hasMany('App\LanguageCulture');
    }

    /**
     * Get the lessonNotes belongs to the lesson.
     *　レッスンンに属する「lessonNotes」を取る。
     */
    public function lessonNotes()
    {
        return $this->hasMany('App\LessonNote');
    }
}
