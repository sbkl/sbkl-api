<?php

namespace sbkl\SbklApi\Http\Controllers\Api\Admin;

use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Models\Region;
use sbkl\SbklApi\Models\Store;
use sbkl\SbklApi\Models\User;
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
