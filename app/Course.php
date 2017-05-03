<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *　割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'id', 'thumbnail', 'name', 'description', 'age', 'author', 'added_by', 'last_updated_by',
    ];

    /**
	 * Get the administrator that added the course.
	 * コースを追加した管理者を取る。
	 */
	public function administrator_added()
	{
	    return $this->belongsTo('App\Administrator', 'added_by');
	}

    /**
	 * Get the administrator that last updated the course.
	 * コースを最終更新した管理者を取る。
	 */
	public function administrator_last_updated()
	{
	    return $this->belongsTo('App\Administrator', 'last_updated_by');
	}

    /**
     * Get the lessons belongs to the course.
     *　コースに属するレッスンを取る。
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
}
