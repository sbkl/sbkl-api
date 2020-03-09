<?php

namespace sbkl\SbklApi\Traits;

trait Deactivates
{
    public function deactivate()
    {
        $this->update([
            'deactivated_at' => now(),
        ]);
    }

    public function activate()
    {
        $this->update([
            'deactivated_at' => null,
        ]);
    }

    public function getDeactivatedAttribute()
    {
        return (bool) $this->deactivated_at != null;
    }
}
