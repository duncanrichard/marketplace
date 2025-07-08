<header class="header py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-20">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> {{ __('Menu') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right d-flex justify-content-end align-items-center">

                    {{-- Notifikasi --}}
                    @php
                    $unreadNotifications = Auth::user()->notifikasi()->where('dibaca', false)->latest()->take(5)->get();
                    $totalUnread = $unreadNotifications->count();
                    @endphp

                    <div class="notification-box ml-15 d-none d-md-flex position-relative">
                        <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="lni lni-alarm"></i>
                            @if($totalUnread > 0)
                            <span
                                class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1">
                                {{ $totalUnread }}
                            </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notification"
                            style="min-width: 300px;">
                            @forelse($unreadNotifications as $notif)
                            <li>
                                <a href="{{ route('notifikasi.baca', $notif->id) }}" class="dropdown-item">
                                    <div class="content small">
                                        <p class="mb-1">{{ $notif->pesan }}</p>
                                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="text-center p-3 text-muted">Tidak ada notifikasi baru</li>
                            @endforelse
                        </ul>

                    </div>

                    {{-- Profile --}}
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <h6>{{ Auth::user()->name ?? 'Guest' }}</h6>
                                </div>
                            </div>
                            <i class="lni lni-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <a href="{{ route('profile.show') }}">
                                    <i class="lni lni-user"></i> {{ __('My profile') }}
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="lni lni-exit"></i> {{ __('Logout') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>