@php
    $routeActive = Route::currentRouteName();
    $level = Auth::user()?->role ?? '';
@endphp


@if(Auth::check())
    <li class="nav-item">
        <a class="nav-link {{ $routeActive == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="ni ni-tv-2 text-primary"></i>
            <span class="nav-link-text">Dashboard</span>
        </a>
    </li>

    @if ($level != 'masyarakat')
        @if ($level == 'admin')
            <li class="nav-item">
                <a class="nav-link {{ $routeActive == 'users.index' ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="fas fa-users text-warning"></i>
                    <span class="nav-link-text">Data Pengguna</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link {{ $routeActive == 'items.index' ? 'active' : '' }}" href="{{ route('items.index') }}">
                <i class="fas fa-building text-danger"></i>
                <span class="nav-link-text">Data Barang</span>
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link {{ $routeActive == 'auctions.index' ? 'active' : '' }}" href="{{ route('auctions.index') }}">
            <i class="fas fa-book text-primary"></i>
            <span class="nav-link-text">Data Lelang Barang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $routeActive == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
            <i class="fas fa-user-tie text-success"></i>
            <span class="nav-link-text">Profile</span>
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link {{ $routeActive == 'landing' ? 'active' : '' }}" href="{{ route('landing') }}">
            <i class="ni ni-tv-2 text-primary"></i>
            <span class="nav-link-text">Dashboard</span>
        </a>
    </li>
@endif
