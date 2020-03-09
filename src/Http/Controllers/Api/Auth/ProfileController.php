<?php

namespace sbkl\SbklApi\Http\Controllers\Api\Auth;

use sbkl\SbklApi\Http\Resources\PrivateUserResource;

class ProfileController
{
    public function index()
    {
        return new PrivateUserResource(auth()->user());
    }
}
