<div class="sticky-top h-100 px-2 py-2 bg-dark">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.home' ? ' active' : '' }}" href="{{ route('admin.home') }}">Home</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.dokter.index' ? ' active' : '' }}" href="{{ route('admin.dokter.index') }}">Dokter</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.pasien.index' ? ' active' : '' }}" href="{{ route('admin.pasien.index') }}">Pasien</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.jadwal.index' ? ' active' : '' }}" href="{{ route('admin.jadwal.index') }}">Jadwal</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'admin.booking.index' ? ' active' : '' }}" href="{{ route('admin.booking.index') }}">Booking</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
