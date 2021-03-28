<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
