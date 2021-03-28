<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Service;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokters = Dokter::with('service')->get();

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
        $dokter = Dokter::create([
            'nama' => $request->nama
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
        $dokter = Dokter::with(['service', 'jadwal'])->find($id);

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
        $dokter = Dokter::find($id);
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
        Dokter::find($id)->destroy();

        return redirect()->route('admin.dokter.index');
    }
}
