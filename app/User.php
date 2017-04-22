<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Get the role associated with the user.
     *　ユーザーに関連付けられた役割を取る。
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * The attributes that are mass assignable.
     *　割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'gender', 'date_of_birth', 'role', 'cv',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *　アレイのため、属性が隠されたたほうがいい。
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Get the courses added by the administrator.
     *　コースが管理者に追加されたのを取る。
     */
    public function added_courses()
    {
        return $this->hasMany('App\Course', 'added_by');
    }
    /**
     * Get the courses last updated by the administrator.
     *　コースが管理者に最終更新されたのを取る。
     */
    public function updated_courses()
    {
        return $this->hasMany('App\Course', 'last_updated_by');
    }
    /**
     * Get the lessons added by the administrator.
     *　レッスンが管理者に追加されたのを取る。
     */
    public function added_lessons()
    {
        return $this->hasMany('App\Lesson', 'added_by');
    }
    /**
     * Get the lessons last updated by the administrator.
     *　レッスンが管理者に最終更新されたのを取る。
     */
    public function updated_lessons()
    {
        return $this->hasMany('App\Lesson', 'last_updated_by');
    }
}
