<?php

namespace App\Http\Controllers\Api\Auth;

class LoginController
{
    public function logout()
    {
        request()->user()->token()->revoke();
        $json = [
            'success' => true,
            'code' => 200,
            'message' => 'You are Logged out.',
        ];

        return response()->json($json, '200');
    }
}
