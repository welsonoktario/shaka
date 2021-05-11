@extends('layouts.admin')

@section('title', 'Booking')
@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between my-4">
      <h1 class="h3 mb-0 text-gray-800 d-none d-md-inline-block d-lg-inline-block d-xl-inline-block">Booking</h1>
      <button id="btnTambahBooking" class="d-sm-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Booking</button>
    </div>

    <div class="table-responsive rounded-lg bg-white shadow-lg">
      <table id="tableBooking" class="table m-2" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Pasien</th>
            <th>Dokter</th>
            <th class="text-center">Servis</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bookings as $booking)
            <tr id="listBooking">
              <td>{{ $booking->pasien->user->nama }}</td>
              <td>{{ $booking->slot->jadwal->dokter->nama }}</td>
              <td class="text-center">
                <span class="badge badge-primary">{{ $booking->service->nama }}</span>
              </td>
              <td class="text-center">
                <button id="btnEditBooking" data-id="{{ $booking->id }}" class="btn btn-primary">Detail</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div id="modalBooking" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        {{-- Loading --}}
        <div id="modalLoading" class="row h-100 align-items-center">
          <div class="col align-self-center">
            <div class="d-flex my-5 justify-content-center">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
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
      $('.toast').toast();
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
        $('#modalBooking').modal('show');
        $('#modalBookingContent').html('');
        $('#modalLoading').show();
        $.get(`booking/create`, function(res) {
          $('#modalLoading').hide();
          $('#modalBookingContent').html(res);
        });
      });

      $('#listBooking #btnEditBooking').click(function() {
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
