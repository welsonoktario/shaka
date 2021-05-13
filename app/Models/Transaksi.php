<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
