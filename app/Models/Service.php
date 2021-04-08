<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function dokter()
    {
        return $this->belongsToMany(User::class, 'dokter_service');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
