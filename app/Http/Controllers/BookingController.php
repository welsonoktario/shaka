<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Role;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC');

        return view('app.booking.index', ['bookings' => $bookings]);
    }

    public function indexAdmin()
    {
        $bookings = Booking::with(['slot.jadwal.dokter', 'pasien.user', 'service'])->get();

        return view('admin.booking.index', ['bookings' => $bookings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('role')->find(Auth::id());
        $dokters = User::with('service')->where('role_id', 2)->get();

        if ($user->role->id === 1) {
            return view('admin.booking.create', ['dokters' => $dokters]);
        } else {
            return view('app.booking.create', ['dokters' => $dokters]);
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
        $user = User::find(Auth::id());
        $user->booking()->create([
            'metode_pembayaran' => $request->metode,
            'waktu' => $request->waktu,
            'service_id' => $request->service
        ]);

        return redirect('/booking');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $booking = Booking::with(['pasien.user', 'slot.jadwal.dokter.service'])->find($id);
        $tanggal = Carbon::create($booking->slot->jadwal->start)->toDateString();
        $start = Carbon::create($booking->slot->jadwal->start)->toTimeString();
        $end = Carbon::create($booking->slot->jadwal->end)->toTimeString();

        return view($request->tipe === 'pasien' ? 'app.booking.show' : 'admin.booking.show', [
            'dokter' => $booking->slot->jadwal->dokter,
            'pasien' => $booking->pasien,
            'jadwal' => $booking->slot->jadwal,
            'tanggal' => $tanggal,
            'start' => $start,
            'end' => $end,
            'slot' => $booking->slot->jadwal->jumlah_slot,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::with('service')->find($id);

        return view('app.booking.show', ['booking' => $booking]);
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
        $service = Service::find($request->service);
        $booking = Booking::find($id);
        $booking->service()->associate($service);

        return redirect('/booking');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();

        return redirect('/booking');
    }

    public function slotJadwal($id) {
        $slots = Jadwal::with(['slot.booking'])->find($id);

        return $slots->toJson();
    }
}
