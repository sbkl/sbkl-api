<?php

namespace App\Http\Controllers\Api\Auth;

class LanguageController
{
    public function update()
    {
        auth()->user()->update([
            'lang' => request('lang'),
        ]);
    }
}
