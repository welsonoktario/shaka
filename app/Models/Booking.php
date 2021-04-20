<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['slot_id', 'pasien_id', 'service_id', 'tanggal'];
    public $timestamps = false;

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function bookingManual()
    {
        return $this->hasOne(BookingManual::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
