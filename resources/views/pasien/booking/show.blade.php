<div class="modal-header">
  <h5 class="modal-title">Pasien</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
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
        <li id="slot{{ $slot->id }}" data-nomor="{{ $slot->nomor }}" class="list-group-item">
          <span>Slot {{ $slot->nomor }}: </span>
          @if (!$booked)
            <button id="btnTambahBooking" class="btn btn-outline-primary btn-sm"
              data-dokter="{{ $jadwal->dokter->id }}" data-slot="{{ $slot->id }}">Booking</button>
          @else
            <span> - </span>
          @endif
        </li>
      @endif
    @endforeach
  </ul>
</div>
<div class="modal-footer d-flex justify-content-between">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>
