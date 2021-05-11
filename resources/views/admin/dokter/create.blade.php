<form action="{{ route('admin.dokter.store') }}" method="POST">
  <div class="modal-header">
    <h5 class="modal-title">Tambah Dokter</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    @csrf
    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" id="nama">
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" id="email">
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">No. HP</label>
      <input type="tel" name="hp" class="form-control" id="hp">
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-3">
      <label class="from-label">Servis</label>
      @foreach ($services as $service)
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}"
            id="service{{ $service->id }}">
          <label class="form-check-label" for="service{{ $service->id }}">
            {{ $service->nama }}
          </label>
        </div>
      @endforeach
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Tambah</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
  </div>
</form>
