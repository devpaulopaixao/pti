<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
