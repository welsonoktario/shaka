<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingManual extends Model
{
    protected $fillable = ['booking_id', 'nama', 'no_hp'];
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
