@extends('layouts.admin')

@section('content')
    <div class="px-4 py-2">
        <div class="mb-4 d-flex justify-content-between">
            <h2>Jadwal</h2>
        </div>
        <div id="calendarJadwal"></div>
    </div>

    <div id="modalJadwal" class="modal fade" tabindex="-1">
        <div id="modalJadwalContent" class="modal-dialog"></div>
    </div>

    <div class="toast position-absolute m-4 bottom-0 end-0 align-items-center text-white border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
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
                    start: jadwal.start,
                    end: jadwal.end,
                    title: `${jadwal.dokter.nama} (${jadwal.slot} slot)`,
                    bg: `hsla(${Math.random() * 360}, 100%, 50%, 1)`,
                }
            })
            const calendar = new FullCalendar.Calendar($("#calendarJadwal")[0], {
                plugins: [interactionPlugin, timeGridPlugin],
                initialView: 'timeGridWeek',
                selectable: true,
                editable: true,
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
                select: function(cell) {
                    const start = moment(cell.startStr).format('YYYY-MM-DD HH:mm');
                    const end = moment(cell.endStr).format('YYYY-MM-DD HH:mm');

                    $.get(`jadwal/create?start=${start}&end=${end}`, function(res) {
                        $('#modalJadwalContent').html(res);
                        $('#modalJadwal').modal('show');
                    });
                },
                selectOverlap: function(event) {
                    return !event.block;
                },
                eventDrop: function(cell) {
                    const start = moment(cell.event.startStr).format('YYYY-MM-DD HH:mm');
                    const end = moment(cell.event.endStr).format('YYYY-MM-DD HH:mm');

                    $.ajax({
                        url: `jadwal/${cell.event.id}`,
                        type: 'PUT',
                        data: {
                            start,
                            end
                        },
                        success: function(res) {
                            console.log(res);
                        }
                    });
                },
                eventResize: function(cell) {
                    console.log(cell.event);
                    const start = moment(cell.event.startStr).format('YYYY-MM-DD HH:mm');
                    const end = moment(cell.event.endStr).format('YYYY-MM-DD HH:mm');

                    $.ajax({
                        url: `jadwal/${cell.event.id}`,
                        type: 'PUT',
                        data: {
                            start,
                            end
                        },
                        success: function(res) {
                            console.log(res);
                        }
                    });
                },
                eventClick: function(event) {
                    $.get(`jadwal/${event.event.id}`, function(res) {
                        $('#modalJadwalContent').html(res);
                        $('#modalJadwal').modal('show');
                    });
                    $('#modalJadwal').on('show.bs.modal', function() {
                        const modal = $(this);
                        modal.find('#btnHapus').click(function() {
                            $.ajax({
                                url: `jadwal/${cell.event.id}`,
                                type: 'DELETE',
                                success: function(res) {
                                    if (res === 'ok') {
                                        $('.toast').removeClass(
                                                'bg-primary bg-danger')
                                            .addClass('bg-primary');
                                        $('.toast .toast-body').html(
                                            'Berhasil menghapus jadwal');
                                        $('.toast').toast('show');
                                        cell.event.remove();
                                    } else {
                                        $('.toast').removeClass(
                                                'bg-primary bg-danger')
                                            .addClass('bg-primary');
                                        $('.toast .toast-body').html(
                                            'Gagal menghapus jadwal');
                                        $('.toast').toast('show');
                                    }
                                }
                            });
                        });
                    });
                }
            });
            calendar.render();
        });

    </script>
@endsection
