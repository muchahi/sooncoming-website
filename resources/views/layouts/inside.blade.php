<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Soon Comming || @yield('title')</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />
   <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ env('APP_ASSETS') }}/assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- In your layouts/app.blade.php -->



    <!-- swiper carousel css -->
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

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
</head>

<body class="body-scroll theme-pink" data-page="">
    @include('components.script')
    <!-- loader section -->
    @include('components.inc.loader')
    <!-- loader section ends -->

    
    <!-- Begin page -->
    <main class="h-100">

        <!-- Header -->
        <header class="header position-fixed header-filled">
            <div class="row">
                <div class="col-auto">
                    <button type="button" class="btn btn-light btn-44 back-btn btn-rounded">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <div class="col">
                    <div class="logo-small rounded-circle">
                        <img src="{{ env('APP_ASSETS') }}/assets/img/logo.png" alt="" class="rounded-circle" />
                        <h5>{{ env('APP_SLUG_NAME') }}<br /><span class="text-secondary fw-light">Shopping</span></h5>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="profile" target="_self" class="btn btn-light btn-44 btn-rounded">
                        <i class="bi bi-person-circle"></i>
                        <span class="count-indicator"></span>
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


    <!-- Required jquery and libraries -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/jquery-3.3.1.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/popper.min.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/main.js"></script>
    <script src="{{ env('APP_ASSETS') }}/assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/pwa-services.js"></script>

    <!-- Chart js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="{{ env('APP_ASSETS') }}/assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    <!-- page level custom script -->
    <script src="{{ env('APP_ASSETS') }}/assets/js/app.js"></script>
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

    if (productId === 0 || productId === null) {
        toastr.error('Please select a product to save.'); // Show error if product ID is empty
        return; // Stop the function if product ID is empty
    }

    fetch('/wishlist/toggle', {  // Use proper Laravel route for toggling wishlist
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
        },
        body: JSON.stringify({
            user_id: userId,
            product_id: productId
        }),
    })
    .then(response => response.json()) // Parse JSON response
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

</body>

</html>
