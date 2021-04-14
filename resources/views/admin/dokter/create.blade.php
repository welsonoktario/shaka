<div class="modal-header">
    <h5 class="modal-title">Tambah Dokter</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('admin.dokter.store') }}" method="POST">
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
            <label class="from-label">Servis</label>
            @foreach ($services as $service)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="service{{ $service->id }}">
                    <label class="form-check-label" for="service{{ $service->id }}">
                        {{ $service->nama }}
                    </label>
                </div>
            @endforeach
        </div>
        <button class="btn btn-primary" type="submit">Tambah</button>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
