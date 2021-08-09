<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $dates = ['tanggal'];
    protected $fillable = ['booking_id', 'total', 'tanggal'];
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
