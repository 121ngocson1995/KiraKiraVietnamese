<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
	 * Get the users that have a specific role.
	 */
	public function user()
	{
	    return $this->hasMany('App\User');
	}
}
