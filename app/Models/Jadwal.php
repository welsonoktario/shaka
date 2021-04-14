<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['start', 'end', 'tanggal', 'jumlah_slot'];
    public $timestamps = false;

    public function dokter()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function slot()
    {
        return $this->hasMany(Slot::class);
    }
}
