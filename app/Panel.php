<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function screen()
    {
        return $this->hasMany('App\Screen', 'panel_id', 'id');
    }
}
