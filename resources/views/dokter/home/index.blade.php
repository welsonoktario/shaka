@extends('layouts.dokter')

@section('title', 'Jadwal Hari Ini')
@section('content')
<div class="px-4 py-2">
  @if (!$jadwal)
    tidak ada jadwal hari ini:)
  @else
    <h3 id="antrian">No Antrian: Slot {{ $antrian }}</h3>
    <div class="row row-cols-5">
      @foreach ($jadwal->slot as $slot)
        <div class="col">
          <div class="card card-booking">
            @if ($slot->booking)
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold text-primary">Slot {{ $loop->iteration }}</h6>
                <div class="badge" data-id="{{ $slot->booking->id }}">{{ $slot->booking->status }}</div>
              </div>
              <div class="card-body">
                <p class="card-title fw-bold">{{ $slot->booking->pasien->user->nama }}</p>
                <p class="card-subtitle">{{ $slot->booking->service->nama }}</p>
              </div>
              <div class="card-footer bg-white">
                @if ($slot->booking->status == 'Diproses')
                  <button class="btn btn-success btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                    data-tipe="selesai">
                    <span class="fa fa-check me-1"></span>
                    Selesai
                  </button>
                  <button class="btn btn-secondary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                    data-tipe="lewati" disabled>Lewati</button>
                @elseif ($slot->booking->status == 'Dilewati')
                  <button class="btn btn-primary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                    data-tipe="proses">Proses</button>
                  <button class="btn btn-secondary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                    data-tipe="lewati">Lewati</button>
                @elseif ($slot->booking->status == 'Selesai')
                  <button class="btn btn-success btn-aksi text-white" data-tipe="selesai" disabled>
                    <span class="fa fa-check me-1"></span>
                    Selesai
                  </button>
                @else
                  @if ($slot->nomor == $antrian)
                    <button class="btn btn-primary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                      data-tipe="proses">Proses</button>
                    <button class="btn btn-secondary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                      data-tipe="lewati">Lewati</button>
                  @else
                    <button class="btn btn-primary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                      data-tipe="proses" disabled>Proses</button>
                    <button class="btn btn-secondary btn-aksi text-white" data-id="{{ $slot->booking->id }}"
                      data-tipe="lewati" disabled>Lewati</button>
                  @endif
                @endif
              </div>
            @else
              <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Slot {{ $loop->iteration }}</h6>
              </div>
              <div class="card-body">
                <p class="card-title fw-bold">Kosong</p>
                <p class="card-subtitle"> - </p>
              </div>
              <div class="card-footer bg-white">
                <p class="text-center"> - </p>
              </div>
            @endif
          </div>
        </div>
      @endforeach
  @endif
</div>

<div id="modalTransaksi" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable overflow-auto">
    <div class="modal-content">

      {{-- Loading --}}
      <div id="modalLoading" class="row h-100 align-items-center">
        <div class="col align-self-center">
          <div class="d-flex my-5 justify-content-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Memuat...</span>
            </div>
          </div>
        </div>
      </div>

      <div id="modalTransaksiContent"></div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
  $(function() {
    cekStatus();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('.card-booking .card-footer .btn-aksi').click(function() {
      const tipe = $(this).data('tipe');
      const id = $(this).data('id');

      if (tipe == 'selesai') {
        openModalTransaksi(id);
      } else {
        handleBooking(id, tipe);
      }
    });
  });

  function cekStatus() {
    const booking = $('.badge');
    booking.each(function(i, el) {
      switch ($(el).text()) {
        case "Pending":
          $(el).addClass('bg-warning');
          break;
        case "Diproses":
          $(el).addClass('bg-primary');
          break;
        case "Dilewati":
          $(el).addClass('bg-secondary');
          break;
        case "Selesai":
          $(el).addClass('bg-success');
          break;
        default:
          break;
      }
    });
  }

  function openModalTransaksi(id) {
    $('#modalTransaksi').modal('show');
    $('#modalTransaksiContent').html('');
    $('#modalLoading').show();
    $.get(route('dokter.home.createTransaksi', id), function(res) {
      $('#modalLoading').hide();
      $('#modalTransaksiContent').html(res);
      $('#btnBuat').click(function() {
        const total = $('#totalTransaksi').val();
        handleBooking(id, 'selesai', total);
      });
    });
  }

  function lewatiBooking(id) {
    $(el).attr('data-tipe', 'selesai');
    $(el).data('tipe', 'selesai');
    $(`.badge[data-id='${id}']`).removeClass('bg-warning').addClass('bg-secondary');
    $(`.badge[data-id='${id}']`).text('Dilewati');
  }

  function prosesBooking(id) {
    $(`.btn-aksi[data-id='${id}'][data-tipe='proses']`).removeClass('btn-primary').addClass('btn-success');
    $(`.btn-aksi[data-id='${id}'][data-tipe='proses']`).html('<span class="fa fa-check me-1"></span> Selesai ');
    $(`.btn-aksi[data-id='${id}'][data-tipe='proses']`).attr('data-tipe', 'selesai');
    $(`.btn-aksi[data-id='${id}'][data-tipe='selesai']`).data('tipe', 'selesai');
    $(`.btn-aksi[data-id='${id}'][data-tipe='lewati']`).prop('disabled', true);
    $(`.badge[data-id='${id}']`).removeClass('bg-warning').addClass('bg-primary');
    $(`.badge[data-id='${id}']`).text('Diproses');
  }

  function selesaiBooking(id, booking) {
    $(`.btn-aksi[data-id='${id}'][data-tipe='selesai']`).prop('disabled', true);
    $(`.btn-aksi[data-id='${id}'][data-tipe='lewati']`).remove();
    $(`.btn-aksi[data-id='${booking.id}'][data-tipe='proses']`).prop('disabled', false);
    $(`.btn-aksi[data-id='${booking.id}'][data-tipe='lewati']`).prop('disabled', false);
    $(`.badge[data-id='${id}']`).removeClass('bg-primary').addClass('bg-success');
    $(`.badge[data-id='${id}']`).text('Selesai');
    $('#antrian').text(`No Antrian: Slot ${booking.slot.nomor}`);
    $('#modalTransaksi').modal('hide');
  }

  function handleBooking(id, tipe, total = null) {
    $.ajax({
      url: route('dokter.home.handleBooking', id),
      type: 'PATCH',
      data: {
        tipe,
        total
      },
      success: function(res) {
        switch (tipe) {
          case 'proses':
            prosesBooking(id);
            break;
          case 'lewati':
            lewatiBooking(id);
            break;
          case 'selesai':
            const bookingBaru = res.booking;
            selesaiBooking(id, bookingBaru);
            break;
          default:
            break;
        }
      },
      error: function(err) {
        console.log('err ', err);
      }
    });
  }
</script>
@endpush
