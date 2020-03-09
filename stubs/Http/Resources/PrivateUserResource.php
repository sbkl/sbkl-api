<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'lang' => $this->lang,
            'password_changed' => (bool) $this->password_changed_at,
            'plant_id' => $this->plant ? $this->plant->id : null,
            'plant_name' => $this->plant ? $this->plant->name : null,
            'market' => $this->plant ? ($this->plant->market ? $this->plant->market->name : null) : null,
            'region' => $this->plant ? ($this->plant->market ? $this->plant->market->region->name : null) : null,
            'role' => $this->role,
        ];
    }
}
