<?php

namespace App\Http\Controllers\Api\Admin;

use App\Region;

class RegionController
{
    public function store()
    {
        request()->validate([
            'name' => 'required|unique:regions,name',
        ]);
        Region::create([
            'company_id' => auth()->user()->company->id,
            'name' => request('name'),
        ]);
    }

    public function update($regionId)
    {
        $region = Region::find($regionId);
        request()->validate([
            'name' => "required|unique:regions,name,{$region->id}",
        ]);
        $region->update([
            'name' => request('name'),
        ]);
    }

    public function destroy($regionId)
    {
        $region = Region::find($regionId);
        if ($region->market_count === 0 && $region->store_count === 0) {
            $region->delete();
        } else {
            $json = [
                'success' => false,
                'code' => 422,
                'errors' => [
                    'regions' => ['The region cannot be deleted'],
                ],
            ];

            return response()->json($json, '422');
        }
    }
}
