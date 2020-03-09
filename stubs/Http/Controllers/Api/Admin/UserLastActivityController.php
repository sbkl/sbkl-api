<?php

namespace App\Http\Controllers\Api\Admin;

class UserLastActivityController
{
    public function update()
    {
        auth()->user()->update([
            'last_activity_at' => now(),
        ]);
    }
}
