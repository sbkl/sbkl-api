<?php

namespace sbkl\SbklApi\Tests\Setup;

use sbkl\SbklApi\Models\User;

class UserFactory
{
    protected $plant = null;
    protected $role = null;

    public function as($role)
    {
        $this->role = $role;

        return $this;
    }

    public function withPlant($plant)
    {
        $this->plant = $plant;

        return $this;
    }

    public function create()
    {
        $plant_type = $this->plant ? get_class($this->plant) : null;

        $user = factory(User::class)->create([
            'company_id' => $plant_type === 'App\Store' ? $this->plant->market->region->company_id : 1,
            'plant_type' => $plant_type,
            'plant_id' => $this->plant ? $this->plant->id : null,
        ]);

        $user->assignRole($this->role ? $this->role : ($plant_type ? ($plant_type === 'App\Store' ? 'BOH' : null) : null));

        return $user;
    }
}
