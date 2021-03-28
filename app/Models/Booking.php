<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['waktu', 'metode_pembayaran', 'service_id'];
    public $timestamps = false;

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
