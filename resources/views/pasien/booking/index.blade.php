@extends('layouts.app')

@section('content')
<div class="px-4 py-2">
    <div class="mb-4 d-flex justify-content-between">
        <h2>Booking</h2>
    </div>
    <div id="calendarJadwal"></div>
</div>

<div id="modalBooking" class="modal fade" tabindex="-1">
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

<div id="modalTambahBooking" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalLoadingBooking" class="row h-100 align-items-center">
                <div class="col align-self-center">
                    <div class="d-flex my-5 justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modalTambahBookingContent"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const jadwals = {!! $jadwals !!};
        const events = jadwals.map((jadwal) => {
            return {
                id: jadwal.id,
                start: `${jadwal.tanggal} ${jadwal.start}`,
                end: `${jadwal.tanggal} ${jadwal.end}`,
                title: `${jadwal.dokter.nama} (${jadwal.jumlah_slot} slot)`,
            }
        });
        const calendar = new FullCalendar.Calendar($("#calendarJadwal")[0], {
            plugins: [interactionPlugin, timeGridPlugin],
            initialView: 'timeGridWeek',
            editable: false,
            allDaySlot: false,
            views: {
                week: {
                    slotLabelInterval: '00:30:00',
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: 'short',
                        hour12: false
                    }
                }
            },
            events,
            eventClick: function(event) {
                $('#modalBooking').modal('show');
                $('#modalBookingContent').html('');
                $('#modalLoading').show();
                $.get(`jadwal/${event.event.id}`, function(res) {
                    $('#modalLoading').hide();
                    $('#modalBookingContent').html(res);
                });
            }
        });
        calendar.render();

        $('#modalBookingContent').on('click', '#btnTambahBooking', function() {
            const { slot, dokter } = $(this).data();
            $('#modalTambahBooking').modal('show');
            $('#modalTambahBookingContent').html('');
            $('#modalLoadingBooking').show();
            $.get(`booking/create?dokter=${dokter}`, function(res) {
                $('#modalLoadingBooking').hide();
                $('#modalTambahBookingContent').html(res);
            });
        });
    });

    function loadServiceJadwal(id) {
        $('#selectService').html('');
        $('#selectJadwal').html('');
        $('#selectService').append(`<option selected disabled>Pilih service</option>`);
        $('#selectJadwal').append(`<option selected disabled>Pilih jadwal</option>`);
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
        $('#selectSlot').append(`<option selected disabled>Pilih slot</option>`);
        $.get(`booking/slot-jadwal/${id}`, function(res) {
            const jadwal = JSON.parse(res);
            jadwal.slot.forEach(slot => {
                $('#selectSlot').append(`<option value="${slot.id}">${slot.nomor}</option>`)
            });
        });
    }

</script>
@endsection
