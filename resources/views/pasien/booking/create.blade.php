<div class="modal-header">
    <h5 class="modal-title">Tambah Booking</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('pasien.booking.store') }}" method="POST">
    <div class="modal-body">
        @csrf
        <div class="mb-3">
            <label class="from-label">Service</label>
            <select id="selectService" name="service" class="form-select form-control" required>
                <option selected disabled>Pilih service</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Tambah</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
</form>
