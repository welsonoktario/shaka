@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between my-4">
      <h1 class="h3 mb-0 text-gray-800">Pasien</h1>
      <button id="btnTambahPasien" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Pasien</button>
    </div>
    <div class="table-responsive p-4 rounded-lg bg-white shadow-lg">
      <table id="tablePasien" class="table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">Nama</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pasiens as $pasien)
            <tr>
              <td>{{ $pasien->user->nama }}</td>
              <td class="text-center">
                <button id="btnDetailPasien" data-id="{{ $pasien->id }}" class="btn btn-primary">Detail</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div id="modalPasien" class="modal fade" tabindex="-1">
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
        <div id="modalPasienContent"></div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#btnTambahPasien').click(function() {
        $('#modalPasien').modal('show');
        $('#modalPasienContent').html('');
        $('#modalLoading').show();
        $.get(`pasien/create`, function(res) {
          $('#modalLoading').hide();
          $('#modalPasienContent').html(res);
        });
      });

      $('#listPasien #btnDetailPasien').click(function() {
        const id = $(this).data('id');
        $('#modalPasien').modal('show');
        $('#modalPasienContent').html('');
        $('#modalLoading').show();
        $.get(`pasien/${id}`, function(res) {
          $('#modalLoading').hide();
          $('#modalPasienContent').html(res);
        });
      });

      $('#tablePasien').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        columns: [{
            name: 'Nama',
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
