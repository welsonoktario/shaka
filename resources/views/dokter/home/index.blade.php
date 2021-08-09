@extends('layouts.dokter')

@section('title', 'Jadwal Hari Ini')
@section('content')
<div class="px-4 py-2">
  @if (!$jadwal)
    tidak ada jadwal hari ini:)
  @else
    <div class="row row-cols-4">
      @foreach ($jadwal->slot as $slot)
        @if ($slot->booking)
          <div class="col">
            <div class="card card-booking">
              <div class="card-header bg-primary text-white">Slot {{ $loop->iteration }}</div>
              <div class="card-body">
                <h4 class="card-title">{{ $slot->booking->pasien->user->nama }}</h4>
                <h6 class="card-subtitle">{{ $slot->booking->service->nama }}</h6>
              </div>
              <div class="card-footer bg-white">
                @switch($slot->booking->status)
                  @case('Pending')
                    <button class="btn btn-primary btn-aksi" data-id="{{ $slot->booking->id }}"
                      data-tipe="proses">Proses</button>
                    <button class="btn btn-secondary btn-aksi" data-id="{{ $slot->booking->id }}"
                      data-tipe="lewati">Lewati</button>
                  @break
                  @case('Diproses')
                    <button class="btn btn-success btn-aksi" data-id="{{ $slot->booking->id }}" data-tipe="selesai">
                      <span class="fa fa-check mr-1"></span>
                      Selesai
                    </button>
                    <button class="btn btn-secondary btn-aksi" data-id="{{ $slot->booking->id }}" data-tipe="lewati"
                      disabled>Lewati</button>
                  @break
                  @case('Dilewati')
                    <button class="btn btn-primary btn-aksi" data-id="{{ $slot->booking->id }}"
                      data-tipe="proses">Proses</button>
                    <button class="btn btn-secondary btn-aksi" data-id="{{ $slot->booking->id }}"
                      data-tipe="lewati">Lewati</button>
                  @break
                  @case('Selesai')
                    <button class="btn btn-success" disabled>
                      <span class="fa fa-check mr-1"></span>
                      Selesai
                    </button>
                    @default
                    @break
                  @endswitch
                </div>
              </div>
            </div>
          @endif
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
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('.card-booking .card-footer .btn-aksi').click(function() {
        const tipe = $(this).data('tipe');
        const id = $(this).data('id');

        switch (tipe) {
          case 'proses':
            handleBooking(id, tipe);
            $(this).removeClass('btn-primary').addClass('btn-success');
            $(this).html('<span class="fa fa-check mr-1"></span> Selesai ');
            $(this).attr('data-tipe', 'selesai');
            $(this).data('tipe', 'selesai');
            $(`.btn-aksi[data-id='${id}'][data-tipe='lewati']`).prop('disabled', true);
            break;
          case 'lewati':
            handleBooking(id, tipe);
            break;
          case 'selesai':
            openModalTransaksi(id);
            break;
          default:
            break;
        }
      });
    });

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

    function handleBooking(id, tipe, total = null) {
      $.ajax({
        url: route('dokter.home.handleBooking', id),
        type: 'PATCH',
        data: {
          tipe,
          total
        },
        success: function(res) {
          if (tipe === 'selesai') {
            $(`.btn-aksi[data-id='${id}'][data-tipe='selesai']`).prop('disabled', true);
            $(`.btn-aksi[data-id='${id}'][data-tipe='lewati']`).remove();
            $('#modalTransaksi').modal('hide');
          }
        },
        error: function(err) {
          console.log('err ', err);
        }
      });
    }
  </script>
@endpush
