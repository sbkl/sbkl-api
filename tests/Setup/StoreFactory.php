<?php

namespace sbkl\SbklApi\Tests\Setup;

use Faker\Generator as Faker;
use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Models\Store;

class StoreFactory
{
    protected $id = null;
    protected $name = null;
    protected $marketId = null;
    protected $hubId = null;
    protected $priority = null;

    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function withMarketId($marketId)
    {
        $this->marketId = $marketId;

        return $this;
    }

    public function create()
    {
        $faker = new Faker;
        $store = factory(Store::class)->create([
            'id' => $this->id ?: $faker->uuid,
            'market_id' => $this->marketId ?: factory(Market::class),
            'name' => $this->name ?: $faker->name,
            'channel' => 'Mainline',
        ]);

        return $store;
    }
}
