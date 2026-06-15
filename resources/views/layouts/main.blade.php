<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Soon Comming || Leading online shopping platform</title>
    <!--Google site verification-->
    <meta name="google-site-verification" content="LiUkj7AGyjgKcze-tMXFEO5lnbeMe_-ITcDZMxWOQ_Y" />

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon16.png" sizes="16x16" type="image/png">
    <meta name="services" content="online shopping">
    
    <!--AOS-->
   

    <!-- Google fonts-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- Add Swiper CSS & JavaScript -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- nouislider CSS -->
    <link href="{{ env('APP_ASSETS') }}/assets/vendor/nouislider/nouislider.min.css" rel="stylesheet">

    <!-- date rage picker -->
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/assets/vendor/daterangepicker/daterangepicker.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

    <!-- style css for this template -->

<link href="{{ env('APP_ASSETS') }}/assets/scss/style.css" rel="stylesheet" id="style">
    {{-- toatsr --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    
    <!--AOS SCRIPT-->
   

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
</head>
<!--stylings-->
<style>
    html, body {
        margin-bottom: 30px;
        padding: 2px;
        height: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    main {
        min-height: 100vh;
    }

    .main-container, .container {
        max-width: 100%;
        padding-left: 0;
        padding-right: 0;
        margin: 0 auto;
    }
</style>

<!--end-->
<body class="body-scroll theme-pink" data-page="shop">
    @include('components.script')
    <!-- loader section -->
    @include('components.inc.loader')
    
     
    @if (Auth::check())
        <div class="sidebar-wrap  sidebar-overlay">
              
            <div class="closemenu text-secondary">Close Menu</div>
            <div class="sidebar ">
                 user information 
                <div class="row">
                    <div class="col-12 profile-sidebar">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-100 rounded-20 shadow-sm">
                                    <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <h5 class="mb-2">Brian Muchahi</h5>
                                <p class="text-muted size-12">Nairobi City,<br />Kenya</p>
                            </div>
                        </div>
                    </div>
                </div>

                 
            </div>
        </div>
    @endif
    <div class="sidebar-wrap sidebar-overlay">
    
    <div class="closemenu text-secondary">Close Menu</div>
    <div class="sidebar">
        <!-- User Information -->
        <div class="row">
            <div class="col-12 profile-sidebar">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-100 rounded-20 shadow-sm">
                            @if(Auth::check())
                                <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="">
                            @else
                                <img src="{{ env('APP_ASSETS') }}/assets/img/default-avatar.jpg" alt="">
                            @endif
                        </figure>
                    </div>
                    <div class="col px-0 align-self-center">
                        @if(Auth::check())
                            <h5 class="mb-2">{{ Auth::user()->name }}</h5>
                            <p class="text-muted size-12">{{ Auth::user()->location ?? 'Kenya' }}</p>
                        @else
                            <h5 class="mb-2">Guest User</h5>
                            <p class="text-muted size-12">Welcome! <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        @include('components.inc.side-menu')
    </div>
</div>

    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100">

        <!-- Header -->
        <header class="header position-fixed header-filled">
            <div class="row">
                @if (Auth::check())
                    <div class="col-auto">
                        <button type="button" class="btn btn-light btn-44 btn-rounded menu-btn">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                @endif
                <div class="col">
                    <div class="logo-small">
                        <img src="{{ env('APP_ASSETS') }}/assets/img/logo.png" alt="" class="rounded-circle" />
                        <h5 class="d-none d-lg-block">{{ env('APP_SLUG_NAME') }}<br /><span class="text-secondary fw-light">Shopping</span></h5>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="notifications" target="_self" class="btn btn-light btn-44 btn-rounded">
                        <i class="bi bi-bell"></i>
                        <span class="count-indicator"></span>
                    </a>
                    <a href="profile" target="_self" class="btn btn-light btn-44 btn-rounded ms-2">
                        <i class="bi bi-person-circle"></i>
                    </a>
                </div>
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container">

            @yield('content')
        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('home')}}">
                        <span>
                            <i class="nav-icon bi bi-house"></i>
                            <span class="nav-text">Home</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('products.user')}}">
                        <span>
                            <i class="nav-icon bi bi-binoculars"></i>
                            <span class="nav-text">products</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item centerbutton">
                    <a href="{{ route('cart.index' ) }}" class="nav-link" id="centermenubtn">
                        <span class="theme-linear-gradient">
                            <i class="bi bi-basket size-22"></i>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('orders')}}">
                        <span>
                            <i class="nav-icon bi bi-bag"></i>
                            <span class="nav-text">Orders</span>
                        </span>
                    </a>
                </li>
               <li class="nav-item">
    <a class="nav-link" href="{{ route('wishlist.index') }}">
        <span>
            <i class="nav-icon bi bi-heart"></i>
            <span class="nav-text">Favorites</span>
        </span>
    </a>
</li>

            </ul>
        </div>
    </footer>
    <!-- Footer ends-->

    <!-- filter menu -->
    <div class="filter">
        <div class="card shadow h-100">
            <div class="card-header">
                <div class="row">
                    <div class="col align-self-center">
                        <?php $ps = DB::table('products')->get()->count(); ?>
                        <h6 class="mb-0">Filter Criteria</h6>
                        <p class="text-secondary small">{{$ps}} products</p>
                    </div>
                    <div class="col-auto px-0">
                        <button class="btn btn-link text-danger filter-close">
                            <i class="bi bi-x size-22"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body overflow-auto">

                <div class="col-md-3">
                    <div class="list-group">
                        <a href="{{ route('products.user') }}" 
                           class="list-group-item {{ request('c') ? '' : 'active' }}">
                            All Categories
                        </a>
                        @php
                            $categories = DB::table('product_categories')->get();
                        @endphp
                        @foreach ($categories as $category)
                            <a href="{{ route('products.user', ['c' => $category->id]) }}" 
                               class="list-group-item {{ request('c') == $category->id ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                            <!-- Filtering Form (Add below search form) -->
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="row m-1">
                      
                        <div class="col-md-3 mb-2">
                            <input type="number" name="price_min" class="form-control" placeholder="Min Price" value="{{ request('price_min') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" name="price_max" class="form-control" placeholder="Max Price" value="{{ request('price_max') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-default w-100 shadow-sm shadow-success btn-rounded">Search</button>
            </div>
        </div>
    </div>
    <!-- filter menu ends-->

    <script>
        function updateQuantity(productId, action) {
            const quantityElement = document.getElementById(`item_quantity_${productId}`);
            let quantity = parseInt(quantityElement.innerText);

            // Check the action to determine whether to increment or decrement
            if (action === 'increment') {
                quantity++; // Increase quantity
            } else if (action === 'decrement' && quantity > 0) {
                quantity--; // Decrease quantity only if greater than 0
            }

            // Update the UI
            quantityElement.innerText = quantity;

            // Send the updated quantity to the server
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message); // Show success message

                        // Update the subtotal and total in the UI
                        document.getElementById('subtotal').innerText = 'KSH ' + data.subtotal + '.00';
                        document.getElementById('totalamount').innerText = 'KSH ' + data.total + '.00';
                    } else {
                        toastr.error(data.message); // Show error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Failed to update quantity.');
                });
        }


        function addToCart(productId, quantity) {
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure you include the CSRF token
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity // Pass the quantity, defaults to 1 if not provided
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message); // Display success message with Toastr
                    } else {
                        toastr.error('Failed to add product to cart.'); // Handle failure case
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while adding to cart.');
                });
        }

function saveWishlist(productId, userId) {
    if (userId === 0) {
        toastr.error('Please log in to save to wishlist.'); // Show error if user is not logged in
        return; // Stop the function if user ID is empty
    }

    fetch('/wishlist/toggle', {  // Update the endpoint to match the wishlist toggle route
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Add CSRF token
        },
        body: JSON.stringify({
            user_id: userId,
            product_id: productId
        }),
    })
    .then(response => response.json())  // Parse JSON response
    .then(data => {
        const heartIcon = document.getElementById(`heart-icon-${productId}`);

        if (data.success) {
            if (data.action === 'added') {
                heartIcon.classList.remove('bi-heart');
                heartIcon.classList.add('bi-heart-fill');
                toastr.success('Product added to wishlist!');
            } else if (data.action === 'removed') {
                heartIcon.classList.remove('bi-heart-fill');
                heartIcon.classList.add('bi-heart');
                toastr.info('Product removed from wishlist.');
            }
        } else {
            toastr.error('Failed to update wishlist.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred. Please try again later.'); // Show error if fetch fails
    });
}


        function updateUrlParam(locationId) {
            const url = new URL(window.location.href);

            // Add or update the 'location' parameter
            url.searchParams.set('l', locationId);

            // Reload the page with the updated URL
            window.location.href = url;
        }

        function removeSearchKeys() {
            const url = new URL(window.location.href); // Get the current URL
            url.searchParams.delete('q'); // Remove the search query parameter
            window.location.href = url.toString(); // Reload the page with the updated URL
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchButton = document.getElementById('searchmainbtn'); // Button selector
            const searchInput = document.getElementById('searchmaininput'); // Input field selector

            searchButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim(); // Get the search term

                if (searchTerm) {
                    const url = new URL(window.location.href); // Get the current URL

                    // Set or update the search query parameter
                    url.searchParams.set('q', searchTerm);

                    // Reload the page with the updated URL
                    window.location.href = url.toString();
                }
            });

            // Remove filter functionality

        });
    </script>

    <script src="{{ env('APP_ASSETS') }}/assets/js/jquery-3.3.1.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/popper.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/main.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/color-scheme.js"></script>

    <!-- Chart js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    <!-- daterange picker script -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- nouislider js -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/nouislider/nouislider.min.js"></script>

    <!-- PWA app service registration and works -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/pwa-services.js"></script>

    <!-- page level custom script -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/app.js"></script>

   
   

</body>

</html>
