<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\PrivateUserResource;

class ProfileController
{
    public function index()
    {
        return new PrivateUserResource(auth()->user());
    }
}
