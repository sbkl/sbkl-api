<?php

namespace App\Http\Controllers\Api\Admin;

use App\Market;
use App\Region;

class MarketController
{
    public function store()
    {
        request()->validate([
            'region' => 'required|exists:regions,name',
            'name' => 'required|unique:markets,name',
        ]);
        Market::create([
            'region_id' => Region::whereName(request('region'))->first()->id,
            'name' => request('name'),
        ]);
    }

    public function update($marketId)
    {
        $market = Market::find($marketId);
        request()->validate([
            'region' => 'required|exists:regions,name',
            'name' => "required|unique:markets,name,{$market->id}",
        ]);
        $market->update([
            'region_id' => Region::whereName(request('region'))->first()->id,
            'name' => request('name'),
        ]);
    }

    public function destroy($marketId)
    {
        $market = Market::find($marketId);
        if ($market->store_count === 0) {
            $market->delete();
        } else {
            $json = [
                'success' => false,
                'code' => 422,
                'errors' => [
                    'markets' => ['The market cannot be deleted'],
                ],
            ];

            return response()->json($json, '422');
        }
    }
}
