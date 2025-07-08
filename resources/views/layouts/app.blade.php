<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>DSoft</title>

    <!-- ========== CSS utama ========= -->
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ========== Select2 CSS ========= -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('styles')
</head>
<body>

<!-- ======== Sidebar start =========== -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo/logo.svg') }}" alt="logo"/>
        </a>
    </div>
    <nav class="sidebar-nav">
        @include('layouts.navigation')
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== Sidebar end =========== -->

<!-- ======== Main wrapper start =========== -->
<main class="main-wrapper">

    <!-- ========== Header start ========== -->
    @include('layouts.header')
    <!-- ========== Header end ========== -->

    <!-- ========== Main section start ========== -->
    <section class="section">
        <div class="container-fluid">
            @include('layouts.messages')
            @yield('content')
        </div>
    </section>
    <!-- ========== Main section end ========== -->

    <!-- ========== Footer start =========== -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-last order-md-first">
                    <div class="copyright text-md-start">
                        <p class="text-sm">
                            Designed and Developed by
                            <a href="https://plainadmin.com" rel="nofollow" target="_blank">PlainAdmin</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ========== Footer end =========== -->
</main>
<!-- ======== Main wrapper end =========== -->

<!-- ========== JavaScript Files ========= -->

<!-- jQuery (wajib sebelum Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle (Popper.js + Bootstrap JS) -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- App Custom JS -->
<script src="{{ asset('js/main.js') }}"></script>

@yield('scripts')

</body>
</html>
