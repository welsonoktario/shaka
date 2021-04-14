@extends('layouts.admin')

@section('content')
    <div class="px-4 py-2">
        <div class="mb-4 d-flex justify-content-between">
            <h2>Dokter</h2>
            <button id="btnTambahDokter" class="btn btn-primary">Tambah Dokter</button>
        </div>
        <table id="tableDokter" class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Servis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dokters as $dokter)
                    <tr id="listDokter">
                        <td>{{ $dokter->nama }}</td>
                        <td>
                            @foreach ($dokter->service as $service)
                                <span class="badge bg-primary">{{ $service->nama }}</span>
                            @endforeach
                        </td>
                        <td>
                            <button id="btnEditDokter" data-id="{{ $dokter->id }}" class="btn btn-primary">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="modalDokter" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div id="modalDokterContent" class="modal-content">
                <div id="modalLoading" class="row h-100 align-items-center">
                    <div class="col align-self-center">
                        <div class="d-flex my-5 justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#btnTambahDokter').click(function () {
                $('#modalDokter').modal('show');
                $('#modalDokterContent').html('');
                $('#modalLoading').show();
                $.get(`dokter/create`, function (res) {
                    $('#modalLoading').hide();
                    $('#modalDokterContent').append(res);
                });
            });

            $('#listDokter #btnEditDokter').click(function() {
                const id = $(this).data('id');
                $('#modalDokter').modal('show');
                $('#modalDokterContent').html('');
                $('#modalLoading').show();
                $.get(`dokter/${id}/edit`, function (res) {
                    $('#modalLoading').hide();
                    $('#modalDokterContent').html(res);
                });
            });

            $('#tableDokter').DataTable({
                columns: [
                    { name: 'Nama', orderable: true },
                    { name: 'Service', orderable: false },
                    { name: '', orderable: false }
                ]
            });
        });
    </script>
@endsection
