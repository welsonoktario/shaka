<div class="modal-header">
    <h5 class="modal-title">Pasien</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <h5>Jadwal</h5>
    <ul class="list-group list-group-flush mb-3">
        <li class="list-group-item">Dokter: {{ $jadwal->dokter->nama }}</li>
        <li class="list-group-item">Waktu Mulai: {{ $jadwal->start }}</li>
        <li class="list-group-item">Waktu Akhir: {{ $jadwal->end }}</li>
    </ul>
    <h5>Pasien</h5>
    <ul class="list-group list-group-flush">
        @foreach ($jadwal->slot as $slot)
            @if (isset($slot->booking))
                <li class="list-group-item">Slot {{ $slot->nomor }}: {{ $slot->booking->pasien->user->nama }}</li>
            @else
                <li class="list-group-item">
                    <span>Slot {{$slot->nomor}}: </span>
                    <button id="btnTambahBooking" class="btn btn-outline-primary btn-sm" data-dokter="{{ $jadwal->dokter->id }}" data-slot="{{ $slot->id }}">Booking</button>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<div class="modal-footer d-flex justify-content-between">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
