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
                            <span class="badge bg-primary">{{ $booking->service->nama }}</span>
                        </td>
                        <td>
                            <button id="btnEditBooking" data-id="{{ $booking->id }}" class="btn btn-primary">Edit</button>
                        </td>
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

            $('#modalBooking').on('show.bs.modal', function(e) {
                if ($(this).data('tipe') === 'tambah') {
                    $('#selectDokter').change(function() {
                        console.log('henlo');
                        console.log($(this).val());
                    });
                }
            });

            $('#tableBooking').DataTable({
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
        });

    </script>
@endsection
