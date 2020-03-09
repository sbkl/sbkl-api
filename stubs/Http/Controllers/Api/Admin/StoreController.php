<?php

namespace App\Http\Controllers\Api\Admin;

use App\Market;
use App\Store;

class StoreController
{
    public function store()
    {
        request()->validate([
            'id' => 'required|unique:stores,id',
            'market' => 'required|exists:markets,name',
            'name' => 'required|unique:stores,name',
            'channel' => 'required',
        ]);
        Store::create([
            'id' => request('id'),
            'market_id' => Market::whereName(request('market'))->first()->id,
            'name' => request('name'),
            'channel' => request('channel'),
        ]);
    }

    public function update($storeId)
    {
        $store = Store::find($storeId);
        request()->validate([
            'name' => "required|unique:stores,name,{$store->id}",
        ]);
        $store->update([
            'name' => request('name'),
        ]);
    }

    public function destroy($storeId)
    {
        $store = Store::find($storeId);
        if ($store->users->count() === 0) {
            $store->delete();
        } else {
            $json = [
                'success' => false,
                'code' => 422,
                'errors' => [
                    'stores' => ['The store cannot be deleted'],
                ],
            ];

            return response()->json($json, '422');
        }
    }

    public function activate($storeId)
    {
        $store = Store::find($storeId);
        $store->activate();
    }

    public function deactivate($storeId)
    {
        $store = Store::find($storeId);
        $store->deactivate();
    }
}
