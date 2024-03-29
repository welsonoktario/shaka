<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class HomeController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with('slot.booking.pasien.user')->firstWhere([
            ['dokter_id', Auth::user()->dokter->id],
            ['tanggal', Carbon::now()->toDateString()]
        ]);

        if (!$jadwal) {
            return view('dokter.home.index', ['jadwal' => $jadwal]);
        }

        $antrian = $jadwal->slot->filter(
            fn ($slot) => ($slot->booking != null && $slot->booking->status == 'Pending' ||
                $slot->booking != null && $slot->booking->status == 'Diproses')
        );


        return view('dokter.home.index', [
            'jadwal' => $jadwal,
            'antrian' => [
                'nomor' => count($antrian) ? $antrian->first()->nomor : '-',
                'pertama' => count($antrian) ? $antrian->first()->nomor : '-',
                'terakhir' => count($antrian) ? $antrian->last()->nomor : '-'
            ]
        ]);
    }

    public function createTransaksi($id)
    {
        $booking = Booking::with(['service', 'pasien.user'])->find($id);

        return view('dokter.home.create', ['booking' => $booking]);
    }

    public function handleBooking(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);

            switch ($request->tipe) {
                case 'selesai':
                    Transaksi::create([
                        'booking_id' => $booking->id,
                        'total' => $request->total,
                        'tanggal' => Carbon::now()
                    ]);
                    $booking->update([
                        'status' => 'Selesai'
                    ]);
                    $booking = Booking::with('slot')
                        ->whereNotIn('id', [$booking->id])
                        ->where('status', 'Pending')
                        ->orWhere('status', 'Diproses')
                        ->first();

                    // return response()->json(['status' => 'ok', 'booking' => $booking ?: 'kosong']);
                    break;
                case 'proses':
                    $booking->update([
                        'status' => 'Diproses'
                    ]);
                    break;
                case 'lewati':
                    $booking->update([
                        'status' => 'Dilewati'
                    ]);
                    break;
                default:
                    break;
            }
        } catch (Throwable $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }

        return redirect()->route('dokter.home.index');
    }
}
