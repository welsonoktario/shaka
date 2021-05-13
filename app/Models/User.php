<?php

namespace App\Models;

use App\Dokter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password', 'role_id', 'no_hp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pasien()
    {
        return $this->hasOne(Pasien::class);
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'dokter_service');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
