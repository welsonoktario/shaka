@extends('layouts.admin')

@section('content')
    <div class="px-4 py-2">
        <div class="mb-4 d-flex justify-content-between">
            <h2>Booking</h2>
            <button id="btnTambahBooking" class="btn btn-primary">Tambah Booking</button>
        </div>
        <table id="tableBooking" class="table">
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Servis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr id="listBooking">
                        <td>{{ $booking->pasien->user->nama }}</td>
                        <td>{{ $booking->slot->jadwal->dokter->nama }}</td>
                        <td>
                            <span class="badge bg-primary my-auto">{{ $booking->service->nama }}</span>
                        </td>
                        <td>
                            <button id="btnEditBooking" data-id="{{ $booking->id }}"
                                class="btn btn-primary">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="modalBooking" class="modal fade" data-tipe="tambah">
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
            $.fn.select2.defaults.set("theme", "bootstrap-5");

            $('#tableBooking').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                },
                columns: [{
                        name: 'Pasien',
                        orderable: true
                    },
                    {
                        name: 'Dokter',
                        orderable: true
                    },
                    {
                        name: 'Service',
                        orderable: true
                    },
                    {
                        name: '',
                        orderable: false
                    }
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
                    loadCreate()
                });
            });

            $('#listBooking #btnEditBooking').click(function() {
                $('#modalBooking').data('tipe', 'edit');
                const id = $(this).data('id');
                $('#modalBooking').modal('show');
                $('#modalBookingContent').html('');
                $('#modalLoading').show();
                $.get(`booking/${id}`, function(res) {
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

        function loadCreate() {
            $('.selectOption').each(function() {
                $(this).select2({
                    placeholder: `Pilih ${$(this).data('label')}`,
                    language: 'id'
                });
            });
        }

        function loadServiceJadwal(id) {
            $('#selectService').html('');
            $('#selectJadwal').html('');
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
            $.get(`booking/slot-jadwal/${id}`, function(res) {
                const jadwal = JSON.parse(res);
                jadwal.slot.forEach(slot => {
                    $('#selectSlot').append(`<option value="${slot.id}">${slot.nomor}</option>`)
                });
            });
        }

    </script>
@endsection
