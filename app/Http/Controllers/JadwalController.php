<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwals = Jadwal::with('dokter')->get();

        return view('admin.jadwal.index', ['jadwals' => $jadwals]);
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

        return view('admin.jadwal.create', ['dokters' => $dokters, 'waktu' => $waktu]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['dokter', 'booking.user'])->find($id);

        return view('admin.jadwal.show', ['jadwal' => $jadwal]);
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
        $dokter->jadwal()->create([
            'start' => $request->start,
            'end' => $request->end,
            'slot' => $request->slot,
        ]);

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
            'end' => $request->end
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
