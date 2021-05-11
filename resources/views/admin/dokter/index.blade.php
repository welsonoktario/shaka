@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between my-4">
      <h1 class="h3 mb-0 text-gray-800">Dokter</h1>
      <button id="btnTambahDokter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokter</button>
    </div>
    <div class="table-responsive p-4 rounded-lg bg-white shadow-lg">
      <table id="tableDokter" class="table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">Nama</th>
            <th class="text-center">Servis</th>
            <th class="text-center">Tanggal Terdaftar</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($dokters as $dokter)
            <tr>
              <td>{{ $dokter->nama }}</td>
              <td>
                @foreach ($dokter->service as $service)
                  <span class="badge badge-primary">{{ $service->nama }}</span>
                @endforeach
              </td>
              <td class="text-center" data-order="{{ $dokter->created_at }}">
                {{ \Carbon\Carbon::parse($dokter->created_at)->format('d F Y') }}</td>
              <td class="text-center">
                <button id="btnShowDokter" data-id="{{ $dokter->id }}" class="btn btn-sm btn-primary mr-1">Detail</button>
                <button id="btnEditDokter" data-id="{{ $dokter->id }}" class="btn btn-sm btn-secondary ml-1">Edit</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div id="modalDokter" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
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

        {{-- Content --}}
        <div id="modalDokterContent"></div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#btnTambahDokter').click(function() {
        $('#modalDokter').modal('show');
        $('#modalDokterContent').html('');
        $('#modalLoading').show();
        $.get(`dokter/create`, function(res) {
          $('#modalLoading').hide();
          $('#modalDokterContent').html(res);
        });
      });

      $('#listDokter #btnEditDokter').click(function() {
        const id = $(this).data('id');
        $('#modalDokter').modal('show');
        $('#modalDokterContent').html('');
        $('#modalLoading').show();
        $.get(`dokter/${id}/edit`, function(res) {
          $('#modalLoading').hide();
          $('#modalDokterContent').html(res);
        });
      });

      $('#tableDokter').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        columns: [{
            name: 'Nama',
            orderable: true
          },
          {
            name: 'Service',
            orderable: false
          },
          {
            name: 'Tanggal Terdaftar',
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
