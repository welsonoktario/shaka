<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokters = Dokter::with(['user', 'service'])->get();

        return view('admin.dokter.index', ['dokters' => $dokters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return view('admin.dokter.create', ['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->hp,
            'role_id' => 2,
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('dokter', "{$user->nama}.{$foto->extension()}");

        $dokter = $user->dokter()->create([
            'deskripsi' => $request->deskripsi,
            'foto' => "dokter/{$user->nama}.{$foto->extension()}"
        ]);

        $dokter->service()->attach($request->services);

        return redirect()->route('admin.dokter.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dokter = Dokter::with(['user', 'service', 'jadwal'])->find($id);

        return view('admin.dokter.show', ['dokter' => $dokter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokter = Dokter::with('user')->find($id);
        $servisDokter = $dokter->service()->pluck('id')->toArray();
        $services = Service::all();

        return view('admin.dokter.edit', ['dokter' => $dokter, 'servisDokter' => $servisDokter, 'services' => $services]);
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
        $dokter = Dokter::find($id);
        $dokter->service()->sync($request->services);
        $dokter->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.dokter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dokter::destroy($id);

        return redirect()->route('admin.dokter.index');
    }
}
