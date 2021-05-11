<form action="{{ route('admin.jadwal.store') }}" method="POST">
  <div class="modal-header">
      <h5 class="modal-title">Pilih Dokter</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      @csrf
      <input type="hidden" name="tanggal" value="{{ $tanggal }}">
      <div class="mb-3">
          <label for="dokter" class="form-label">Dokter</label>
          <select name="dokter" class="form-control" id="dokter" required>
              @foreach ($dokters as $dokter)
                  <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
              @endforeach
          </select>
      </div>
      <div class="mb-3">
          <label class="form-label">Waktu Mulai</label>
          <input type="datetime" class="form-control" name="start" value="{{ $waktu[0] }}" readonly />
      </div>
      <div class="mb-3">
          <label class="form-label">Waktu Akhir</label>
          <input type="datetime" class="form-control" name="end" value="{{ $waktu[1] }}" readonly />
      </div>
      <div class="mb-3">
          <label class="form-label">Slot</label>
          <input type="number" class="form-control" name="slot" min="1" value="1" required />
      </div>
  </div>
  <div class="modal-footer">
      <button class="btn btn-primary" type="submit">Tambah</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
  </div>
</form>
