@extends('layouts.inside')
@section('title', $product->name)
@section('content')

    @php
        $this_category = \App\Models\ProductCategory::find($product->category_id);
    @endphp
        <!-- Swiper CDN (for slider) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<!-- Font Awesome 6 CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- product banner -->
    <style>
    .swiper-container {
        width: 100%;
        overflow: hidden;
    }
    .swiper-slide img {
        object-fit: cover;
        width: 100%;
    }
</style>

<style>
.connectionwiper .swiper-slide {
    flex-shrink: 0;
    width: 150px !important; /* or any desired fixed width */
    height: auto !important;
}

.connectionwiper .swiper-slide img {
    height: 120px; /* reduced size */
    width: 100%;
    object-fit: contain;
    display: block;
    margin: 0 auto;
}

.connectionwiper .card {
    height: auto; /* ensures the card is not floating or stretched */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

.connectionwiper .card-body {
    padding: 10px;
    height: auto;
}
</style>


    <div class="row">
        <div class="swiper-container connectionwiper">
           
                <div class="swiper-wrapper">
                    {{-- loop images --}}
                    <?php
                    
                    $images = explode(',', $product->images);
                    
                    ?>


                    @foreach ($images as $image)
                        @php
                            $image_name = trim($image, '"');

                        @endphp


                        <div class="swiper-slide ">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt=""
                                        class="w-100 rounded-15">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
           
        </div>
    </div>
    
    
    <!-- name and description -->
    <div class="row mb-2">
        <div class="col">
            <p class="text-secondary small">{{ $this_category->name }}</p>


        </div>
        <div class="col-auto">
            <p class="small">
                <span class="text-secondary">{{ number_format($product->stars, 1) }} ({{ $product->reviews }}
                    Reviews)</span>
                <i class="bi bi-star-fill text-warning"></i>
            </p>
        </div>
    </div>
    <h4 class="mb-2">{{ $product->name }}</h4>
    <div class="row mb-3">
        <div class="col align-self-center">
            @if ($product->discount_percentage > 0)
                <h5>KSH {{ number_format($product->price - $product->price * $product->discount_percentage * 0.01, 2) }}
                    <s class="small text-secondary fw-light">KSH {{ $product->price }}</s>
                </h5>
            @else
                <h5>KSH {{ number_format($product->price, 2) }}</h5>
            @endif

        </div>
      
    </div>

    <!-- delivery time -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-opac-50 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <div class="card">
                                <div class="card-body p-0">
                                    <figure class="text-center mb-0 avatar avatar-60 bg-theme rounded-15">
                                        <i class="bi bi-clock size-24 "></i>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col align-self-center ps-0">
                           @auth
                                <h6 class="mb-1">
                                    {{ Auth::user()->address }}
                                    <a href="{{ route('address') }}" class="text-color-theme float-end small">
                                        Change <i class="bi bi-chevron-right"></i>
                                    </a>
                                </h6>
                            @endauth

                            <p><span class="text-opac">Delivery on:</span>
                                <strong>
                                    {{ \Carbon\Carbon::now()->addDays(1)->format('F d, Y g:i A') }}
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Custom CSS for the buttons -->
<style>
    @media (max-width: 768px) {
        /* Ensure buttons have the same height on mobile */
        .btn-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%; /* Buttons stretch to the height of the container */
        }

        /* Make both buttons full-width on mobile */
        .col-12 {
            padding-left: 5px;
            padding-right: 5px;
        }

        /* Add margin between buttons on mobile */
        .col-6 + .col-6 {
            margin-top: 2px; /* Space between buttons on mobile */
        }
    }

    /* Desktop styles */
    .btn-custom {
        border-radius: 5px; /* Box-like shape */
        padding: 2px 5px; /* Consistent padding for both mobile and desktop */
        font-size: 12px; /* Adjust font size for desktop view */
    }

    /* Add spacing between columns on desktop */
    .col-md-6 {
        padding: 0 10px; /* Space between buttons on desktop */
    }

    /* Optional: remove extra margin/padding for the row */
    .row.mb-4 {
        margin-right: 0;
        margin-left: 0;
    }
</style>


 
 <!-- buttons -->
 <!-- First row: Add to Cart button (centered in col-12) -->
 
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-center" style="margin-top:8px;">
        <a href="../addaddress?p={{ $product->id }}&&action=add" class="btn btn-default btn-lg shadow-sm w-100 btn-custom d-flex flex-column align-items-center justify-content-center">
            <!-- Add to Cart Icon -->
            <i class="fas fa-shopping-cart fa-3x mb-2"></i>
            <!-- Add to Cart Text -->
            <span>Add to Cart</span>
        </a>
    </div>
</div>

<!-- Second row: Order via WhatsApp and Buy Now buttons (both in a single row, split into col-6) -->
<div class="row">
    <!-- Order via WhatsApp Button -->
    <div class="col-6 col-md-6 mb-3 mb-md-0">
        <a href="{{ $whatsappLink }}" id="whatsapp-button" target="_blank" class="btn btn-default btn-lg shadow-sm w-100 btn-custom d-flex flex-column align-items-center justify-content-center">
            <!-- WhatsApp Icon -->
            <i class="fab fa-whatsapp fa-3x mb-2"></i>
            <!-- WhatsApp Text -->
            <span>Order via WhatsApp</span>
        </a>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const whatsappButton = document.getElementById("whatsapp-button");
                const mobileWhatsappLink = "{{ $whatsappLink }}"; // Mobile-friendly link (wa.me)
                const desktopWhatsappLink = "{{ $whatsappWebLink }}"; // WhatsApp Web link for Desktop (web.whatsapp.com)

                // Check if the user is on a mobile or desktop device
                if (navigator.userAgent.match(/iPhone|Android|BlackBerry|IEMobile|Opera Mini/i)) {
                    // Mobile: Keep the original WhatsApp mobile link (wa.me)
                    whatsappButton.href = mobileWhatsappLink;
                } else {
                    // Desktop: Use WhatsApp Web link (web.whatsapp.com)
                    whatsappButton.href = desktopWhatsappLink;
                }
            });
        </script>
    </div>

    <!-- Buy Now Button -->
    <div class="col-6 col-md-6 mb-3 mb-md-0">
        <a href="../cart?p={{ $product->id }}&&action=buy" class="btn btn-success btn-lg shadow-sm w-100 text-white btn-custom d-flex flex-column align-items-center justify-content-center">
            <!-- Buy Now Icon -->
            <i class="fas fa-credit-card fa-3x mb-2"></i>
            <!-- Buy Now Text -->
            <span>Buy Now</span>
        </a>
    </div>
</div>


    <h5 class="mb-3">Product Description</h5>
     <!-- Display the description as a list -->
     
        <p class="text-secondary">
            <ul class="list-unstyled">
                @foreach ($details as $detail)
                    <li><strong>{{ $detail }}</strong></li>
                @endforeach
            </ul>
        </p>




    <div class="row mb-3">

        <div class="col-12 text-center mb-3">
            <button class="btn btn-sm btn-outline-info me-2 btn-rounded" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="bi bi-share"></i> Share
            </button>
     @php
    $inWishlist = Auth::check() && Auth::user()->wishlists->contains('product_id', $product->id);
@endphp

                    <button id="favorite-button-{{ $product->id }}"
    onclick="toggleWishlist({{ $product->id }}, {{ Auth::check() ? Auth::id() : 'null' }} )"
    class="btn btn-sm btn-26 rounded-circle shadow-sm shadow-danger text-white bg-danger">
    <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
</button>
<span class="ms-1">Wishlist</span> 



        </div>
        <div class="collapse col-12 " id="collapseExample">
            <div class="justify-content-center text-center">
                <p class="mb-1 text-opac">Share product with</p>
                {{-- Share link with message of this product, adding name and description --}}
                @php
                    $productUrl = env('APP_URL') . '/product/' . $product->id;
                    $message = urlencode("Check out this product: {$product->name} - {$product->description}");
                @endphp

                <a href="https://www.instagram.com/your_username" 
                   class="btn btn-link text-color-theme" target="_blank">
                   <i class="bi bi-instagram"></i>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $productUrl }}"
                    class="btn btn-link text-color-theme" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://www.tiktok.com/@soon_comming"
                   class="btn btn-link text-color-theme" target="_blank">
                   <i class="bi bi-tiktok"></i>
                </a>


                <a href="https://wa.me/?text={{ $message }}%20{{ $productUrl }}"
                    class="btn btn-link text-color-theme" target="_blank"><i class="bi bi-whatsapp"></i></a>

            </div>
        </div>
    </div>
    


    <!-- related product  -->
    <div class="row mb-3">
        <div class="col">
            <h6 class="title">Related Products</h6>
        </div>
    </div>
    <!--products -->
    <div class="row mb-3">
        <div class="col-12 px-0">
            <!-- swiper categories -->
            @php
                $relatedProducts = \App\Models\Product::where('category_id', $this_category->id)
                    ->where('id', '!=', $product->id)
                    ->limit(5)
                    ->get();
            @endphp

        <div class="swiper-container connectionwiper">
            <div class="swiper-wrapper">
                    @if ($relatedProducts->count() > 0)

                        @foreach ($relatedProducts as $p)
                            @php
                                $image_name = trim(explode(',', $p->images)[0], '"');
                            @endphp
                            <div class="swiper-slide text-center">
                                <a href="{{ route('products.show', $p->id) }}"
                                    class="card text-center bg-theme text-white">
                                    <div class="card-body p-1">
                                        <figure class="avatar avatar-90 rounded-15 mb-1">
                                            <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                                alt="">
                                        </figure>
                                        <p class="text-center size-12"><small
                                                class="text-muted">{{ $p->name }}</small><br />KSH
                                            {{ $p->price }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    @endif



                </div>
            </div>
        </div>
    </div>
<!-- Swiper CSS -->
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const swiper = new Swiper('.connectionwiper', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            freeMode: true,
            grabCursor: true,
        });
    });
</script>

    
<script>
function toggleWishlist(productId, userId) {
    if (userId === 0) {
        // Guest User - Handle Wishlist in Local Storage
        let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

        if (wishlist.includes(productId)) {
            wishlist = wishlist.filter(id => id !== productId);
            updateWishlistUI(productId, false);
            showToast("Product removed from wishlist.", "info");
        } else {
            wishlist.push(productId);
            updateWishlistUI(productId, true);
            showToast("Product added to wishlist!", "success");
        }

        localStorage.setItem("wishlist", JSON.stringify(wishlist));
        return;
    }

    // Logged-in User - Handle Wishlist in Database
    fetch(/wishlist/toggle/${productId}, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateWishlistUI(productId, data.action === "added");
            showToast(data.action === "added" ? "Product added to favorites!" : "Product removed from favorites!", "success");
        } else {
            showToast("Failed to update wishlist.", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showToast("Something went wrong. Please try again!", "error");
    });
}

function updateWishlistUI(productId, isAdded) {
    let icon = document.getElementById(heart-icon-${productId});
    let button = document.getElementById(favorite-button-${productId});

    if (isAdded) {
        icon.classList.remove("bi-heart");
        icon.classList.add("bi-heart-fill");
        button.classList.remove("bg-secondary");
        button.classList.add("bg-danger");
    } else {
        icon.classList.remove("bi-heart-fill");
        icon.classList.add("bi-heart");
        button.classList.remove("bg-danger");
        button.classList.add("bg-secondary");
    }
}

// Load Guest Wishlist on Page Load
document.addEventListener("DOMContentLoaded", function () {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    wishlist.forEach(productId => updateWishlistUI(productId, true));
});

// Function to show toast notifications
function showToast(message, type) {
    let bgColor = "";
    if (type === "success") bgColor = "green";
    if (type === "info") bgColor = "blue";
    if (type === "warning") bgColor = "orange";
    if (type === "error") bgColor = "red";

    let toast = document.createElement("div");
    toast.innerText = message;
    toast.style.cssText = 
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: ${bgColor};
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 1000;
        font-size: 14px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    ;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

<!-- Swiper JS (for the slider functionality) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>


@endsection    