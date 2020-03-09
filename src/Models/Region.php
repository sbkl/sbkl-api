<?php

namespace sbkl\SbklApi\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Region extends Model
{
    use HasRelationships;
    protected $guarded = [];
    protected $appends = ['market_count', 'store_count'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function markets()
    {
        return $this->hasMany(Market::class);
    }

    public function getMarketCountAttribute()
    {
        return $this->markets->count();
    }

    public function stores()
    {
        return $this->hasManyThrough(Store::class, Market::class);
    }

    public function getStoreCountAttribute()
    {
        return $this->stores()->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
