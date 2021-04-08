<div class="sticky-top h-100 px-2 py-2">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.home' ? ' active' : '' }}" href="{{ route('admin.home') }}">Home</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.dokter.index' ? ' active' : '' }}" href="{{ route('admin.dokter.index') }}">Dokter</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.jadwa.index' ? ' active' : '' }}" href="{{ route('admin.jadwal.index') }}">Jadwal</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.booking.index' ? ' active' : '' }}" href="{{ route('admin.booking.index') }}">Booking</a>
        </li>
    </ul>
</div>
