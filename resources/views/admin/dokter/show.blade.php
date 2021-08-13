<div class="modal-header">
  <h5 class="modal-title">Detail Dokter</h5>
  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <h5>Profil</h5>
  <div class="mx-2 mb-3">
    <div class="row">
      <dt class="col-4">Nama</dt>
      <dd class="col-8">{{ $dokter->nama }}</dd>
    </div>
  </div>
  <h5>Servis</h5>
  <div class="mx-2">
    <div class="row">
      <dt class="col-4">Service</dt>
      <ul class="col-8">
        @foreach ($dokter->service as $service)
          <li class="badge bg-primary">{{ $service->nama }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
</div>
