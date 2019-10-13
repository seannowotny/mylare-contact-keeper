<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function user()
    {
        return $this->belongsTo(App\User::class);
    }

    protected $fillable = [
        'type', 'name', 'email', 'phone'
    ];
}
