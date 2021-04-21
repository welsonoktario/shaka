@extends('layouts.app')

@section('content')
{{-- <div class="px-4 py-2">
    <div class="mb-4 d-flex justify-content-between">
        <h2>Tambah Booking</h2>
    </div>

    <form class="container mx-auto" action="{{ route('pasien.booking.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="nama">Nama</label>
            <input class="form-control" type="text" name="nama" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="hp">No HP</label>
            <input class="form-control" type="tel" name="hp" />
        </div>
        <div class="mb-3">
            <label class="from-label">Dokter</label>
            <select id="selectDokter" class="form-select form-control" required>
                <option selected disabled>Pilih dokter</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Service</label>
            <select id="selectService" name="service" class="form-select form-control" required>
                <option selected disabled>Pilih service</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Jadwal</label>
            <select id="selectJadwal" class="form-select form-control" required>
                <option selected disabled>Pilih jadwal</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="from-label">Slot</label>
            <select id="selectSlot" name="slot" class="form-select form-control" required>
                <option selected disabled>Pilih slot</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Tambah</button>
    </form>
</div> --}}
<div class="px-4 py-2">
    <div class="mb-4 d-flex justify-content-between">
        <h2>Booking</h2>
        <button id="btnTambahBooking" class="btn btn-primary">Tambah Booking</button>
    </div>
    <table id="tableBooking" class="table">
        <thead>
            <tr>
                <th>Dokter</th>
                <th>Servis</th>
                <th>Jadwal</th>
                <th>Slot</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr id="listBooking">
                    <td>{{ $booking->slot->jadwal->dokter->nama }}</td>
                    <td>
                        <span class="badge bg-primary my-auto">{{ $booking->service->nama }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($booking->slot->jadwal->tanggal)->translatedFormat('l, d F Y') }}</td>
                    {{-- <td>{{ date('l, d F Y', strtotime($booking->slot->jadwal->tanggal)) }}</td> --}}
                    <td>{{ $booking->slot->nomor }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="modalBooking" class="modal fade" tabindex="-1" data-tipe="tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalLoading" class="row h-100 align-items-center">
                <div class="col align-self-center">
                    <div class="d-flex my-5 justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modalBookingContent"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#tableBooking').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            },
            columns: [
                {
                    name: 'Dokter',
                    orderable: true
                },
                {
                    name: 'Service',
                    orderable: true
                },
                {
                    name: 'Jadwal',
                    orderable: true
                },
                {
                    name: 'Slot',
                    orderable: false
                },
            ]
        });

        $('#btnTambahBooking').click(function() {
            $('#modalBooking').data('tipe', 'tambah');
            $('#modalBooking').modal('show');
            $('#modalBookingContent').html('');
            $('#modalLoading').show();
            $.get(`booking/create`, function(res) {
                $('#modalLoading').hide();
                $('#modalBookingContent').html(res);
            });
        });

        $('#modalBookingContent').on('change', '#selectDokter', function() {
            loadServiceJadwal($(this).val());
        });

        $('#modalBookingContent').on('change', '#selectJadwal', function() {
            loadSlotJadwal($(this).val());
        });
    });

    function loadServiceJadwal(id) {
        $('#selectService').html('');
        $('#selectJadwal').html('');
        $('#selectService').append(`<option selected disabled>Pilih service</option>`);
        $('#selectJadwal').append(`<option selected disabled>Pilih jadwal</option>`);
        $.get(`booking/dokter-service/${id}`, function(res) {
            const dokter = JSON.parse(res);
            dokter.service.forEach(service => {
                $('#selectService').append(`<option value="${service.id}">${service.nama}</option>`);
            });

            dokter.jadwal.forEach(jadwal => {
                $('#selectJadwal').append(
                    `<option value="${jadwal.id}">${jadwal.tanggal}: ${jadwal.start} - ${jadwal.end}</option>`
                    );
            });
        });
    }

    function loadSlotJadwal(id) {
        $('#selectSlot').html('');
        $('#selectSlot').append(`<option selected disabled>Pilih slot</option>`);
        $.get(`booking/slot-jadwal/${id}`, function(res) {
            const jadwal = JSON.parse(res);
            jadwal.slot.forEach(slot => {
                $('#selectSlot').append(`<option value="${slot.id}">${slot.nomor}</option>`)
            });
        });
    }

</script>
@endsection
