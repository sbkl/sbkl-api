<?php

namespace sbkl\SbklApi\Traits;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Passport\HasApiTokens;
use sbkl\SbklApi\Models\Company;
use sbkl\SbklApi\Notifications\PasswordResetEmailSent;
use Spatie\Permission\Traits\HasRoles;

trait sbkl
{
    use HasApiTokens, Notifiable, Deactivates, HasRoles;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plant()
    {
        return $this->morphTo();
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first()->name;
    }

    public function getCreatedAtDiffForHumansAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getLastActivityAtDiffForHumansAttribute()
    {
        return !$this->last_activity_at ? 'Never' : Carbon::parse($this->last_activity_at)->diffForHumans();
    }

    public function sendPasswordResetEmail($token)
    {
        Notification::send($this, new PasswordResetEmailSent($this, $token));
    }
}
