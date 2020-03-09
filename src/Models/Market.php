<?php

namespace sbkl\SbklApi\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $guarded = [];
    protected $appends = ['store_count'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function getStoreCountAttribute()
    {
        return $this->stores->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
