<ul>
    <li class="nav-item @if(request()->routeIs('home')) active @endif">
        <a href="{{ route('home') }}">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px; fill: none" fill="none" viewBox="0 0 22 22" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </span>
            <span class="text">{{ __('Home') }}</span>
        </a>
    </li>
    <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
    <a href="#">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4V3H3v7zm0 11h4v-7H3v7zm7 0h4V10h-4v11zm7 0h4V14h-4v7zm0-18v4h4V3h-4z" />
            </svg>
        </span>
        <span class="text">{{ __('Dashboard') }}</span>
    </a>
</li>

    <li class="nav-item @if(request()->routeIs('data-pasien.index')) active @endif">
        <a href="{{ route('data-pasien.index') }}">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.656 0 3-1.343 3-3S13.656 5 12 5 9 6.343 9 8s1.344 3 3 3zm0 2c-2.672 0-8 1.344-8 4v1h16v-1c0-2.656-5.328-4-8-4z" />
                </svg>
            </span>
            <span class="text">{{ __('Data Pasien') }}</span>
        </a>
    </li>
    <li class="nav-item @if(request()->routeIs('reservasi.index')) active @endif">
        <a href="{{ route('reservasi.index') }}">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-6 4h6m-6 4h6m4-16H5a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z"/>
                </svg>
            </span>
            <span class="text">Reservasi</span>
        </a>
    </li>

    <li class="nav-item @if(request()->routeIs('users.index')) active @endif">
        <a href="{{ route('users.index') }}">
             <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px; fill: none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </span>
            <span class="text">{{ __('Users') }}</span>
        </a>
    </li>
    <li class="nav-item @if(request()->routeIs('summernote')) active @endif">
        <a href="{{ route('summernote') }}">
             <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
                  <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
                </svg>
            </span>
            <span class="text">{{ __('Summernote') }}</span>
        </a>
    </li>
    <li class="nav-item dropdown @if(request()->routeIs('data-pasien.*')) active @endif">
    <a class="nav-link dropdown-toggle" href="#" id="pasienDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.656 0 3-1.343 3-3S13.656 5 12 5 9 6.343 9 8s1.344 3 3 3zm0 2c-2.672 0-8 1.344-8 4v1h16v-1c0-2.656-5.328-4-8-4z" />
            </svg>
        </span>
        <span class="text">Restore Data</span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="pasienDropdown">
        <li>
            <a class="dropdown-item @if(request()->routeIs('restore.restore-view')) active @endif" href="{{ route('data-pasien.restore-view') }}">
                Restore Data Pasien
            </a>
        </li>
    </ul>
</li>  
  <!--   <li class="nav-item">
        <a href="#" onclick="event.preventDefault(); document.getElementById('cp-logout-form').submit();">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" style="height: 22px; width: 22px; fill: none" fill="none" viewBox="0 0 22 22" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </span>
            <span class="text">{{ __('Logout') }}</span>
        </a>
    </li> -->
</ul>
