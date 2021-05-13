<div class="modal-header">
  <h5 class="modal-title">Detail Dokter</h5>
  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
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
          <li class="badge badge-primary">{{ $service->nama }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-primary">Edit</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>
