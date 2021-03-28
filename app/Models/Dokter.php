<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = ['nama'];

    public function service()
    {
        return $this->belongsToMany(Service::class, 'dokter_service');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
