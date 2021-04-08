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
                        <td>{{ $booking->jadwal->dokter->nama }}</td>
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

    <div id="modalBooking" class="modal fade" tabindex="-1">
        <div id="modalBookingContent" class="modal-dialog"></div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#btnTambahBooking').click(function() {
                $('#modalBooking').modal('show');
                $.get(`dokter/create`, function(res) {
                    $('#modalBookingContent').html(res);
                });
            });

            $('#listBooking #btnEditBooking').click(function() {
                const id = $(this).data('id');
                $('#modalBooking').modal('show');
                $.get(`booking/${id}`, function(res) {
                    $('#modalBookingContent').html(res);
                });
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
