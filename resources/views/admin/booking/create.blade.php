<div class="modal-header">
    <h5 class="modal-title">Tambah Booking</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('admin.booking.store') }}" method="POST">
    <div class="modal-body">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="nama">Nama</label>
            <input class="form-control" type="text" name="nama" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="hp">No HP</label>
            <input class="form-control" type="tel" name="hp" />
        </div>
        <div class="mb-3">
            <label class="from-label">Dokter</label>
            <select id="selectDokter" class="form-select form-control" required>
                <option selected disabled>Pilih dokter</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Service</label>
            <select id="selectService" name="service" class="form-select form-control" required>
                <option selected disabled>Pilih service</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Jadwal</label>
            <select id="selectJadwal" class="form-select form-control" required>
                <option selected disabled>Pilih jadwal</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Slot</label>
            <select id="selectSlot" name="slot" class="form-select form-control" required>
                <option selected disabled>Pilih slot</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Tambah</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
</form>
