@extends('layouts.admin')

@section('content')
    <div class="px-4 py-2">
        <div class="mb-4 d-flex justify-content-between">
            <h2>Pasien</h2>
            <button id="btnTambahPasien" class="btn btn-primary">Tambah Pasien</button>
        </div>
        <table id="tablePasien" class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasiens as $pasien)
                    <tr id="listPasien">
                        <td>{{ $pasien->user->nama }}</td>
                        <td>
                            <button id="btnDetailPasien" data-id="{{ $pasien->id }}" class="btn btn-primary">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="modalPasien" class="modal fade" tabindex="-1">
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
                <div id="modalPasienContent"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#btnTambahPasien').click(function () {
                $('#modalPasien').modal('show');
                $('#modalPasienContent').html('');
                $('#modalLoading').show();
                $.get(`pasien/create`, function (res) {
                    $('#modalLoading').hide();
                    $('#modalPasienContent').html(res);
                });
            });

            $('#listPasien #btnDetailPasien').click(function() {
                const id = $(this).data('id');
                $('#modalPasien').modal('show');
                $('#modalPasienContent').html('');
                $('#modalLoading').show();
                $.get(`pasien/${id}`, function (res) {
                    $('#modalLoading').hide();
                    $('#modalPasienContent').html(res);
                });
            });

            $('#tablePasien').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                },
                columns: [
                    { name: 'Nama', orderable: true },
                    { name: '', orderable: false }
                ]
            });
        });
    </script>
@endsection
