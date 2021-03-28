<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Tambah Dokter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
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
                        <input
                            id="service{{ $service->id }}"
                            class="form-check-input"
                            type="checkbox"
                            name="services[]"
                            value="{{ $service->id }}"
                            @if (in_array($service->id, $servisDokter)) checked @endif
                        >
                        <label class="form-check-label" for="service{{ $service->id }}">
                            {{ $service->nama }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-primary" type="submit">Edit</button>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
</div>
