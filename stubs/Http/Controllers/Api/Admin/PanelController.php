<?php

namespace App\Http\Controllers\Api\Admin;

use App\Market;
use App\Region;
use App\Store;
use App\User;
use Spatie\Permission\Models\Role;

class PanelController
{
    public function index()
    {
        return [
            'regions' => Region::all(),
            'markets' => Market::with('region')->get(),
            'stores' => $stores = Store::with(['market.region', 'users'])->get(),
            // 'plants' => $stores->merge($hubs),
            'plants' => $stores,
            'users' => User::with('plant')->get()->each(function ($user) {
                $user->append('role');
            }),
            'roles' => Role::all(),
        ];
    }
}
