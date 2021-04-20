<div class="sticky-top h-100 px-2 py-2">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'pasien.home' ? ' active' : '' }}" href="{{ route('pasien.home') }}">Home</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'pasien.booking.index' ? ' active' : '' }}" href="{{ route('pasien.booking.index') }}">Booking</a>
        </li>
        <li class="nav-item my-1">
            <a class="nav-link{{ Route::currentRouteName() === 'pasien.transaksi.index' ? ' active' : '' }}" href="{{ route('pasien.transaksi.index') }}">Riwayat</a>
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
