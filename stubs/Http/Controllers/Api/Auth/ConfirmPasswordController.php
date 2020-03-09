<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\PrivateUserResource;
use Illuminate\Support\Facades\Hash;

class ConfirmPasswordController
{
    public function confirm()
    {
        request()->validate([
            'oldPassword' => 'required',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        if (Hash::check(request('oldPassword'), auth()->user()->password)) {
            auth()->user()->update([
                'password' => Hash::make(request('password')),
                'password_changed_at' => now(),
            ]);

            return new PrivateUserResource(auth()->user()->fresh());
        } else {
            $json = [
                'errors' => (object) [
                    'password' => (array) ["The old password doesn't match our record"],
                ],
                'message' => 'The given data was invalid.',
            ];

            return response()->json($json, '401');
        }
    }
}
