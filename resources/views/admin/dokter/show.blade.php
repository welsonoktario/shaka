<div class="modal-header">
  <h5 class="modal-title">Detail Dokter</h5>
  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <h5>Profil</h5>

  <img class="mx-auto d-block mb-3" width="50%" src="{{ asset("storage/{$dokter->foto}") }}">

  <div class="mx-2 mb-3">
    <div class="row">
      <dt class="col-4">Nama</dt>
      <dd class="col-8">{{ $dokter->user->nama }}</dd>
      <dt class="col-4">Services</dt>
      <dd class="col-8">
        <div class="row">
          @foreach ($dokter->service as $service)
            <span class="badge bg-primary">{{ $service->nama }}</span>
          @endforeach
        </div>
      </dd>
      <dt class="col-4">Deskripsi</dt>
      <dd class="col-8">{{ $dokter->deskripsi }}</dd>
    </div>
  </div>


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
</div>
