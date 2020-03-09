<?php

namespace App\Http\Controllers\Api\Admin;

use App\Store;
use App\User;
use Illuminate\Validation\Rule;

class UserController
{
    public function store()
    {
        request()->validate([
            'role' => 'required|exists:roles,name',
            'plant' => Rule::requiredIf(request('role') != 'Admin'),
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'lang' => 'required',
        ]);

        $store = Store::whereName(request('plant'))->first();
        // $hub = Hub::whereName(request('plant'))->first();
        // $model = $store ? $store : ($hub ? $hub : null);
        $user = User::create([
            'company_id' => auth()->user()->company->id,
            'plant_type' => $store ? get_class($store) : null,
            'plant_id' => $store ? $store->id : null,
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'lang' => request('lang'),
            'password' => \Hash::make(config('sbkl.user_default_password')),
        ]);
        $user->assignRole(request('role'));
    }

    public function update($userId)
    {
        $user = User::find($userId);
        request()->validate([
            'role' => 'required|exists:roles,name',
            'plant' => Rule::requiredIf(request('role') != 'Admin'),
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:users,email,{$user->id}",
            'lang' => 'required',
        ]);

        $store = Store::whereName(request('plant'))->first();
        // $hub = Hub::whereName(request('plant'))->first();
        // $model = $store ? $store : ($hub ? $hub : null);
        $user->update([
            'plant_type' => $store ? get_class($store) : null,
            'plant_id' => $store ? $store->id : null,
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'lang' => request('lang'),
            'password' => \Hash::make(config('sbkl.user_default_password')),
        ]);
        $user->removeRole($user->role);
        $user->assignRole(request('role'));
    }

    public function deactivate($userId)
    {
        $user = User::find($userId);
        $user->deactivate();
    }

    public function activate($userId)
    {
        $user = User::find($userId);
        $user->activate();
    }
}
