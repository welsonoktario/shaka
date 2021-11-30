<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasiens = Pasien::with('user')
            ->whereHas('booking', function ($q) {
                return $q->where('status', 'Selesai');
            })
            ->whereHas('booking.dokter', function ($q) {
                return $q->where('user_id', Auth::id());
            })->get();

        return view('dokter.pasien.index', ['pasiens' => $pasiens]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pasien = Pasien::with([
            'user',
            'booking' => function ($q) {
                return $q->where('status', 'Selesai');
            },
            'booking.service',
            'booking.transaksi'
        ])->find($id);

        return view('dokter.pasien.show', ['pasien' => $pasien]);
    }
}
