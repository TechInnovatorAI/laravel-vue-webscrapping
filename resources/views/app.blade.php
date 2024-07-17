<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Scraper</title>
    <link rel="stylesheet" href="{{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link id="themeColors" rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=6470f0825380390019971f21&product=inline-share-buttons&source=platform"
        async="async"></script>
    <style>
        .active-link:hover {
            background-color: #ffa500 !important;
        }
    </style>
</head>

<body>
    <div id="app"></div>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <!--  Import Js Files -->
    <script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--  core files -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
    <!--  current page js files -->
    <script src="{{ asset('dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    {{-- <script src="{{ asset('dist/js/dashboard.js') }}"></script> --}}
</body>

</html>