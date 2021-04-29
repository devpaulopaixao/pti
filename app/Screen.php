<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function panel()
    {
        return $this->belongsTo('App\Panel', 'id', 'panel_id');
    }
}
