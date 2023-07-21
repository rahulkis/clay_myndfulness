<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ asset('assets/images/logo-mini.png') }}" rel="icon" type="image/png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet" />
    @livewireStyles
    @stack('css')
</head>

<body>
    <div class="container-scroller">
        @include ('includes.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            @include ('includes.sidebar')
            <!-- partial -->
            <div class="main-panel" id="app">
                @yield ('content')
                <!-- content-wrapper ends -->
                @include ('includes.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- container-scroller -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    @livewireScripts
    @stack('js')

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('swalalert',data => {
                swal(data['title'], data['subtitle'], data['type']);
            });
        });
    </script>
</body>

</html>
