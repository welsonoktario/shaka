<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from = request()->getRequestUri();

        if (str_contains($from, '/admin')) {
            $jadwals = Jadwal::with('dokter')->get();
            return view('admin.jadwal.index', ['jadwals' => $jadwals]);
        } else if (str_contains($from, '/dokter')) {
            $jadwals = Jadwal::with('dokter')->where('user_id', Auth::id())->get();
            return view('dokter.jadwal.index', ['jadwals' => $jadwals]);
        } else {
            $jadwals = Jadwal::with('dokter')->get();
            return view('pasien.jadwal.index', ['jadwals' => $jadwals]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dokters = User::with('service')->where('role_id', 2)->get();
        $waktu = [$request->start, $request->end];

        return view('admin.jadwal.create', ['dokters' => $dokters, 'waktu' => $waktu, 'tanggal' => $request->tanggal]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $from = request()->getRequestUri();
        $jadwal = Jadwal::with(['dokter', 'slot.booking.pasien.booking.bookingManual'])->find($id);

        if (str_contains($from, '/admin')) {
            return view('admin.jadwal.show', ['jadwal' => $jadwal]);
        } else if (str_contains($from, '/dokter')) {
            return view('dokter.jadwal.show', ['jadwal' => $jadwal]);
        } else {
            return view('pasien.jadwal.show', ['jadwal' => $jadwal]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dokter = User::find($request->dokter);
        $slots = [];

        $jadwal = $dokter->jadwal()->create([
            'start' => $request->start,
            'end' => $request->end,
            'tanggal' => $request->tanggal,
            'jumlah_slot' => $request->slot,
        ]);

        for ($i = 0; $i < $request->slot; $i++) {
            $slots[$i] = ['jadwal_id' => $jadwal->id, 'nomor' => $i + 1];
        }

        Slot::insert($slots);

        return redirect()->route('admin.jadwal.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->update([
            'start' => $request->start,
            'end' => $request->end,
            'tanggal' => $request->tanggal,
        ]);

        return $jadwal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Jadwal::find($id)->delete()) {
            return 'gagal';
        }

        return 'ok';
    }
}
