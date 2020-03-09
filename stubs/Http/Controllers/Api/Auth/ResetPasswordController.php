<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\PrivateUserResource;
use App\PasswordReset;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController
{
    public function requestPasswordReset()
    {
        request()->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $token = Str::random(60);
        PasswordReset::create([
            'email' => request('email'),
            'token' => \Hash::make($token),
        ]);
        User::whereEmail(request('email'))->first()->sendPasswordResetEmail($token);
    }

    public function getUserForPasswordReset()
    {
        request()->validate([
            'token' => 'required',
        ]);
        if ($token = $this->fetchToken()) {
            return new PrivateUserResource(User::whereEmail($token->email)->first());
        } else {
            $json = [
                'success' => false,
                'code' => 422,
                'errors' => [
                    'token' => ['Invalide token'],
                ],
            ];

            return response()->json($json, '422');
        }
    }

    public function resetPassword(User $user)
    {
        request()->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
        if ($token = $this->fetchToken()) {
            $user = User::whereEmail($token->email)->first();
            $user->password = Hash::make(request('password'));
            $user->save();
            PasswordReset::whereEmail($user->email)->get()->each(function ($passwordReset) {
                $passwordReset->delete();
            });
        } else {
            $json = [
                'success' => false,
                'code' => 422,
                'errors' => [
                    'token' => ['Invalide token'],
                ],
            ];

            return response()->json($json, '422');
        }
    }

    protected function fetchToken()
    {
        return PasswordReset::all()->filter(function ($passwordReset) {
            return Hash::check(request('token'), $passwordReset->token);
        })->first();
    }
}
