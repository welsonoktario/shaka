<div class="modal-header">
  <h5 class="modal-title">Buat Transaksi</h5>
  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<div class="modal-body">
  <h6>Detail</h6>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Nama: {{ $booking->pasien->user->nama }}</li>
    <li class="list-group-item">No. HP: {{ $booking->pasien->user->no_hp }}</li>
    <li class="list-group-item">Service: {{ $booking->service->nama }}</li>
  </ul>

  <div class="form-inline mx-1 mt-4">
    <div class="input-group w-100">
      <div class="input-group-prepend">
        <div class="input-group-text">Rp</div>
      </div>
      <input name="total" type="text" id="totalTransaksi" class="form-control" placeholder="Total">
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" id="btnBuat">Buat</button>
</div>
