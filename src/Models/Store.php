<?php

namespace sbkl\SbklApi\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use sbkl\SbklApi\Traits\Deactivates;
use sbkl\SbklApi\Traits\UUID;

class Store extends Model
{
    use UUID, Deactivates;

    protected $guarded = [];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function users()
    {
        return $this->morphMany(User::class, 'plant');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
