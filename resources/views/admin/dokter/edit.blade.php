<form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
  <div class="modal-header">
    <h5 class="modal-title">Edit Dokter</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    @method('PUT')
    @csrf
    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" id="nama" value="{{ $dokter->nama }}">
    </div>
    <div class="mb-3">
      <label class="from-label">Servis</label>
      @foreach ($services as $service)
        <div class="form-check">
          <input id="service{{ $service->id }}" class="form-check-input" type="checkbox" name="services[]"
            value="{{ $service->id }}" @if (in_array($service->id, $servisDokter)) checked @endif>
          <label class="form-check-label" for="service{{ $service->id }}">
            {{ $service->nama }}
          </label>
        </div>
      @endforeach
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Edit</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
  </div>
</form>
