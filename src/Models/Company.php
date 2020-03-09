<?php

namespace sbkl\SbklApi\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Company extends Model
{
    use HasRelationships;

    protected $guarded = [];

    protected $table = 'companies';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function markets()
    {
        return $this->hasManyThrough(Market::class, Region::class);
    }

    public function stores()
    {
        return $this->hasManyDeep(Store::class, [Region::class, Market::class]);
    }
}
