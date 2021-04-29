<?php

namespace App\Observers;
use App\Panel;

class PanelObserver
{
    public function creating(Panel $panel){
        $panel->hash = (string) \Illuminate\Support\Str::uuid();
    }
}
