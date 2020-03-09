<?php

namespace App;

use App\Traits\sbkl;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use sbkl;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['created_at_diff_for_humans', 'last_activity_at_diff_for_humans'];

    protected $guard_name = 'web';
}
