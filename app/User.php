<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Administrator');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
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
