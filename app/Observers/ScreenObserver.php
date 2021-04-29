<?php

namespace App\Observers;
use App\Screen;

class ScreenObserver
{
    public function creating(Screen $screen){
        $screen->number = Screen::count() + 1;
    }
}
