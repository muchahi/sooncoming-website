<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
     <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="">
    <title>oneuiux V2.0 - Mobile HTML template</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- style css for this template -->
    <link href="{{ env('APP_ASSETS') }}/assets/scss/style.css" rel="stylesheet" id="style">
    {{-- toatsr --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NW6R5TNZ');
    </script>
    
    <!-- End Google Tag Manager -->
    
   
    <!--Add swiper Css -->
      <link rel="stylesheet" href="{{ asset('assets/swiper/swiper-bundle.min.css') }}">
  


</head>

<body class="body-scroll d-flex flex-column h-100 theme-pink" data-page="signin">
    @include('components.script')
    <!-- loader section -->
    @include('components.inc.loader')
    <!-- loader section ends -->

    <!-- Header -->
    <header class="header position-fixed header-filled">
        <div class="row">
            <div class="col">
                <div class="logo-small">
                    <img src="{{ env('APP_ASSETS') }}/assets/img/logo.png" alt="" class="rounded-circle" />
                    <h5>{{ env('APP_SLUG_NAME') }}<br /><span class="text-secondary fw-light">Shopping</span></h5>
                </div>
            </div>
            <div class="col-auto">
                <a href="register" target="_self">
                    Sign up
                </a>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- Begin page content -->
    <main class="container-fluid h-100 ">
        <div class="row h-100">
            @yield('content')
        </div>
    </main>
      
      <!--swiper.js-->
   <script src="{{ asset('assets/swiper/swiper-bundle.min.js') }}"></script>


    <!-- Required jquery and libraries -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/jquery-3.3.1.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/popper.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/main.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/pwa-services.js"></script>

    <!-- page level custom script -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/app.js"></script>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var swiper = new Swiper('.connectionwiper', {
            loop: true,  // Infinite loop
            autoplay: {
                delay: 3000,  // Auto slide every 3 seconds
                disableOnInteraction: false,  // Keep autoplay even after interaction
            },
            speed: 500,  // Transition speed
            slidesPerView: 'auto',  // Adjust for mobile
            spaceBetween: 10,  // Space between slides
        });
    });
</script>

</body>

</html>
