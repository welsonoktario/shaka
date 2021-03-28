<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['start', 'end', 'slot'];
    public $timestamps = false;

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
