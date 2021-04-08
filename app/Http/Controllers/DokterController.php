<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokters = User::with('service')->where('role_id', 2)->get();

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
        $dokter = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('12345'),
            'no_hp' => $request->hp,
            'role_id' => 2,
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
        $dokter = User::with(['service', 'jadwal'])->find($id);

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
        $dokter = User::find($id);
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
        $dokter = User::find($id);
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
        User::find($id)->destroy();

        return redirect()->route('admin.dokter.index');
    }
}
