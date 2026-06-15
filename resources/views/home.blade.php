@extends('layouts.main')

@section('title', 'Landing Page')
@section('content')

<?php
    //fetch ids of uni
    $categories = DB::table('product_categories')->limit(10)->get();
    $global_query = request()->input('q');
    
    ?>

@php
if (request()->query('l')) {
$locationId = request()->query('l');

//the products are filtered by location

$random_products = DB::table('products')
->where('name', 'LIKE', '%' . $global_query . '%')
->orWhere('description', 'LIKE', '%' . $global_query . '%')
->orderByRaw('CASE WHEN location_id = ? THEN 0 ELSE 1 END', [$locationId]) // Prioritize specified location
->inRandomOrder()
->limit(10)
->get();

$offer_products = DB::table('products')
->where('name', 'LIKE', '%' . $global_query . '%')
->orWhere('description', 'LIKE', '%' . $global_query . '%')
->orderByRaw('CASE WHEN location_id = ? THEN 0 ELSE 1 END', [$locationId]) // Prioritize specified location
->where('status', 'offer')
->inRandomOrder()
->limit(10)
->get();

$popular_products = DB::table('products')
->where('name', 'LIKE', '%' . $global_query . '%')
->orWhere('description', 'LIKE', '%' . $global_query . '%')
->orderByRaw('CASE WHEN location_id = ? THEN 0 ELSE 1 END', [$locationId]) // Prioritize specified location
->where('status', 'popular')
->inRandomOrder()
->limit(10)
->get();
} else {
$random_products = DB::table('products')
->where('name', 'LIKE', '%' . $global_query . '%')
->orWhere('description', 'LIKE', '%' . $global_query . '%')
->inRandomOrder()
->limit(12)
->get();
$offer_products = DB::table('products')
    ->where('name', 'LIKE', '%' . $global_query . '%')
    ->orWhere('description', 'LIKE', '%' . $global_query . '%')
    ->where('status', 'offer')
    ->orderBy('id', 'desc')  // Sort by the latest updated date first
    ->limit(10)
    ->get();
$popular_products = DB::table('order_product')
    ->join('products', 'order_product.product_id', '=', 'products.id')
    ->select(
        'products.name',
        'products.images',
        'products.category_id',
        'products.status',
        'products.price',
        DB::raw('COUNT(order_product.product_id) as count')
    )
    ->where('order_product.product_id', '>', 1)
    ->groupBy(
        'products.name',
        'products.images',
        'products.category_id',
        'products.status',
        'products.price'
    )
    ->having('count', '>', 2)
    ->orderByDesc('count')
    ->limit(10)
    ->get();


}

//fetch single item

$random_product = DB::table('products')
    ->where('discount_percentage', '>', 1)
    ->inRandomOrder()
    ->first();
     

$image_name = trim(explode(',', $random_product->images)[0], '"');
@endphp

<style>
    /* Ensure the image is clickable */
    .card-body figure.avatar a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .card-body figure.avatar img {
        width: 100%;
        transition: transform 0.1s ease;
        /* Very fast transition for hover effect */
    }

    /* Hide the additional images by default */
    .card-body figure.avatar .additional-images-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.1s ease-in-out;
        /* Very fast transition for opacity */
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        /* Prevent interaction with the images */
    }

    .card-body figure.avatar .additional-images-container img {
        margin: 5px;
        max-width: 45%;
        /* Ensure images are not too large */
        transition: opacity 0.1s ease-in-out;
        /* Very fast transition for opacity */
        opacity: 0;
    }

    /* On hover, show the additional images */
    .card-body figure.avatar:hover .product-image {
        transform: scale(1.1);
        /* Zoom effect */
    }

    .card-body figure.avatar:hover .additional-images-container {
        opacity: 1;
        /* Show additional images */
    }

    .card-body figure.avatar:hover .additional-images-container img {
        opacity: 1;
        /* Make images visible on hover */
    }
</style>
<style>

.gift-card-image-wrapper {
  width: 100%;
  max-width: 100%;
  height: auto;
  overflow: hidden;
  border-radius: 12px;
  padding: 0;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.gift-card-img {
  width: 100%;
  height: auto;
  object-fit: contain; /* changed from cover */
  object-position: center;
  display: block;
  border-radius: 12px;
}

/* Optional tweak for larger screens */
@media (min-width: 992px) {
  .gift-card-image-wrapper {
    margin-right: auto; /* remove the massive 150rem */
    max-width: 400px; /* or set to a size that fits your layout */
  }
}



</style>

<!--sales product-->
<style>
    .sales-title{
       margin-left:5px;
       margin-bottom:10px;
       font-size:20px;
    }  font-weight:bold;
</style>
<!--new arrivals-->
  <style>
      .arrivals-title{
        margin-left:5px;
        margin-bottom:10px;
        font-size:20px;
        font-weight:bold;
      }
  </style>
<!--best selling-->
<style>
    .best-selling-title{
        font-size:20px;
        font-weight:bold;
        margin-left:5px;
    }
</style>


<!-- search -->
<div class="row mb-3">
    <div class="col-12 overflow-hidden">
        <!-- input -->
        <div class="row">
            <div class="col position-relative align-self-center">
                <div class="form-group form-floating mb-1 is-valid">
                    <input type="text" id="searchmaininput" class="form-control" value="{{ $global_query }}"
                        placeholder="Search" onkeydown="handleSearchEnter(event)">
                    <label class="form-control-label" for="searchmain">Search</label>
                    {{-- clear existing search --}}
                    @if ($global_query)
                    <button onclick="removeSearchKeys()"
                        class="btn-sm input-group-text bg-info border-0 input-group-sm position-absolute"
                        style="right: 44px; top: 24px;">
                        {{ $global_query }} <i class="bi bi-trash p-0 m-0"></i>
                    </button>
                    @endif
                    <!-- Search Icon -->

                    <button id="searchmainbtn"
                        class="input-group-text bg-transparent border-0 input-group-sm position-absolute"
                        style="right: 10px; top: 20px;">
                        <i class="bi bi-search"></i>
                    </button>

                </div>
            </div>
            <div class="col-auto align-self-center">
                <button class="btn btn-light btn-44 filter-btn">
                    <i class="bi bi-filter size-22"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!--categories -->
<div class="row mb-3">
    <div class="col-12 px-0">

        <!-- swiper categories -->
        <div class="swiper-container connectionwiper">
            <div class="swiper-wrapper">

                @if (isset($categories))
                @foreach ($categories as $category)
                @php
                $random_item = DB::table('products')
                ->where('category_id', $category->id)
                ->inRandomOrder()
                ->first();
                @endphp
                @if ($random_item)
                @php
                $image_name = trim(explode(',', $random_item->images)[0], '"');
                @endphp


                <div class="swiper-slide text-center">
                    <a href="products?c={{ $category->id }}&t={{ $random_item->type_id }}&q={{ $category->name }}&p=1"
                        class="card text-center mb-2">
                        <div class="card-body p-1">
                            <figure class="avatar avatar-80 rounded-18">
                                <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt="">
                            </figure>
                        </div>
                    </a>
                    <p class="size-10 text-secondary">{{ $category->name }}</p>
                </div>

                @endif
                @endforeach
                @else
                <div class="swiper-slide text-center">
                    <a href="{{ route('products.index', ['c' => 'general', 'p' => 1]) }}" class="card text-center mb-2">
                        <div class="card-body p-1">
                            <figure class="avatar avatar-80 rounded-20">
                                <img src="{{ env('APP_ASSETS') }}/assets/img/categories2.png" alt="">
                            </figure>
                        </div>
                    </a>
                    <p class="size-10 text-secondary">General</p>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!--high light -->

@if ($random_product)
@php
$image_name = trim(explode(',', $random_product->images)[0], '"');
@endphp
<a class="text-decoration-none"
    href="products?c={{ $random_product->category_id }}&&t={{ $random_product->type_id }}&&q={{ $random_product->name }}&&p=1">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card theme-bg">
                <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt="" class="iwatchposition" />
                <div class="card-body py-3">
                    <div class="row">
                        <!--checking if random product is not nll-->
                       
                        <div class="col-auto align-self-center">
                            <h6><span class="fw-light">{{$random_product->discount_percentage}} OFF</span><br />{{ $random_product->name }}</h6>
                        </div>
                        <div class="col-auto align-self-center ms-auto text-end">
                            <h4>OFFER</h4>
                            <p class="size-10"><span class="text-muted">Buy at
                                    {{ $random_product->price }}</span><br />Using
                                Mpesa</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
@endif
<!-- Your original code structure (no changes to this part) -->
<div class="row mb-3">
    <div class="col-12 px-0">
        <!-- swiper categories -->
        <div class="swiper-container connectionwiper">
            <div class="swiper-wrapper">
                @foreach ($random_products as $product)
                @php
                // Assuming 'images' is a comma-separated string, we get the first image
                $image_name = trim(explode(',', $product->images)[0], '"');
                @endphp
                <div class="swiper-slide text-center">
                    <a href="products/{{ $product->id }}" class="card text-center bg-theme text-white">
                        <div class="card-body p-1">
                            <figure class="avatar avatar-90 rounded-15 mb-1">
                                <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                    alt="{{ $product->name }}">
                            </figure>
                            <p class="text-center size-12">
                                <small class="text-muted">{{ $product->name }}</small><br />
                                KSH {{ $product->price }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
 
</div>



<!-- product medsize box  -->

<div class="row mb-2">
<h6 class="title sales-title">Sales Products</h6>


    @foreach ($offer_products as $key => $product)
    @php
    $image_name = trim(explode(',', $product->images)[0], '"');
    @endphp

    <div class="col-6 col-md-4 col-lg-3">
    
        <div class="card mb-3">
            <a href="#" class="text-decoration-none">
                <div class="card-body p-1 position-relative">
                    <div class="position-absolute start-0 top-0 m-2 z-index-1">
                        <div class="tag tag-small bg-theme text-white">
                            26% OFF
                        </div>
                    </div>
                    <div class="position-absolute end-0 top-0 p-2 z-index-1">
                        <button id="favorite-button-{{ $product->id }}"
                            onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
                            class="btn btn-sm btn-26 rounded-circle shadow-sm bg-danger text-white">
                            <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
                        </button>
                    </div>
                    <!-- wrap the image with an <a> tag to make it clickable-->
                           <figure class="avatar w-100 rounded-15 border">
                                <a href="products/{{ $product->id }}">
                                    <!-- This is the default image (shown before hover) -->
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt=""
                                        class="w-100 product-image" id="product-image-{{ $product->id }}">
        
                                    <!-- Additional images that will show on hover -->
                                    <div class="additional-images-container" id="additional-images-{{ $product->id }}">
                                        @foreach (explode(',', $product->images) as $image)
                                        @if ($loop->first)
                                        <!-- Skip the first image, it's already used above -->
                                        @else
                                        <img src="{{ env('APP_ASSETS') }}/product_images/{{ trim($image, ',') }}" alt=""
                                            class="w-100 additional-image">
                                        @endif
                                        @endforeach
                                    </div>
                                </a>
                            </figure>
                            
                    
          
                </div>

                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col">
                            <p class="small">
                                <small class="text-muted size-12">{{ $product->name }}</small><br />
                                KSH {{ $product->price }}
                            </p>
                        </div>
                        <div class="col-auto px-0">
                            <button onclick="addToCart({{ $product->id }})" class="btn btn-sm btn-link text-color-theme">
                                <i class="bi bi-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<?php
$gift_card = DB::table('gift_card')->latest()->first();

?>
<!--Gift card-->
<div class="row mb-2">
    <div class="col-12">
        <div class="card theme-bg overflow-hidden">
            <div class="card-body py-2 px-3">
                <div class="row">
                    <div class="col-12">
                       <div class="gift-card-image-wrapper mx-auto">
                          <img src="{{ asset('assets/img/' . $gift_card->image) }}" alt="Gift Card" class="gift-card-img">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- product medsize box no gap -->

<div class="row mb-4 g-0">
    <div class="col-12">
         <h6 class="title arrivals-title">New Arrivals</h6>
        <div class="card">
            <div class="card-body p-0">
                 
                <!-- 2nd images -->
                
                <div class="row mx-0">
                    @foreach ($random_products as $product)
                    @php
                    // Assuming 'images' is a comma-separated string, we get the first image
                    $image_name = trim(explode(',', $product->images)[0], '"');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 border-end p-3">
                        <div class="position-relative">
                            <div class="position-absolute start-0 top-0 z-index-1">
                                <div class="tag tag-small bg-theme text-white">
                                    
                                    26% OFF
                                </div>
                            </div>
                            <div class="position-absolute end-0 top-0 p-2 z-index-1">
                                <button id="favorite-button-{{ $product->id }}"
                                    onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
                                    class="btn btn-sm btn-26 rounded-circle shadow-sm shadow-danger text-white bg-danger">
                                    <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
                                </button>
                            </div>
                            <!-- wrap the image with an <a> tag to make it clickable-->
                           <figure class="avatar w-100 rounded-15 border">
                                <a href="products/{{ $product->id }}">
                                    <!-- This is the default image (shown before hover) -->
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt=""
                                        class="w-100 product-image" id="product-image-{{ $product->id }}">
        
                                    <!-- Additional images that will show on hover -->
                                    <div class="additional-images-container" id="additional-images-{{ $product->id }}">
                                        @foreach (explode(',', $product->images) as $image)
                                        @if ($loop->first)
                                        <!-- Skip the first image, it's already used above -->
                                        @else
                                        <img src="{{ env('APP_ASSETS') }}/product_images/{{ trim($image, ',') }}" alt=""
                                            class="w-100 additional-image">
                                        @endif
                                        @endforeach
                                    </div>
                                </a>
                            </figure>
                            
                            
                            <div class="row">
                                <div class="col">
                                    <p class="small">
                                        <small class="text-muted size-12">{{ $product->name }}</small><br />
                                        KSH {{ $product->price }}
                                    </p>
                                </div>
                                <div class="col-auto px-0">
                                    <button onclick="addToCart({{ $product->id }})"
                                        class="btn btn-sm btn-link text-color-theme">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Additional row for more products (if needed) -->
                <div class="row mx-0 border-top">
                    @foreach ($random_products->slice(4, 4) as $product)
                    @php
                    $image_name = trim(explode(',', $product->images)[0], '"');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 border-end p-3">
                        <div class="position-relative">
                            <div class="position-absolute start-0 top-0 z-index-1">
                                <div class="tag tag-small bg-danger text-white">SALE</div>
                            </div>
                            <div class="position-absolute end-0 top-0 p-2 z-index-1">
                                <button id="favorite-button-more-{{ $product->id }}"
                                    onclick="toggleMoreToWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
                                    class="btn btn-sm btn-26 rounded-circle shadow-sm shadow-danger text-white bg-danger">
                                    <i class="bi bi-heart size-10 vm" id="heart-icon-more-{{ $product->id }}"></i>
                                </button>

                            </div>
                            
                            <figure class="avatar w-100 rounded-15 border">
                                <a href="products/{{ $product->id }}">
                                    <!-- This is the default image (shown before hover) -->
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}" alt=""
                                        class="w-100 product-image" id="product-image-{{ $product->id }}">
        
                                    <!-- Additional images that will show on hover -->
                                    <div class="additional-images-container" id="additional-images-{{ $product->id }}">
                                        @foreach (explode(',', $product->images) as $image)
                                        @if ($loop->first)
                                        <!-- Skip the first image, it's already used above -->
                                        @else
                                        <img src="{{ env('APP_ASSETS') }}/product_images/{{ trim($image, ',') }}" alt=""
                                            class="w-100 additional-image">
                                        @endif
                                        @endforeach
                                    </div>
                                </a>
        
        
                            </figure>
                            <div class="row">
                                <div class="col">
                                    <p class="small">
                                        <small class="text-muted size-12">{{ $product->name }}</small><br />
                                        KSH {{ $product->price }}
                                    </p>
                                </div>
                                <div class="col-auto px-0">
                                    <button onclick="addToCart({{ $product->id }})"
                                        class="btn btn-sm btn-link text-color-theme">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Best selling  -->

<div class="row mb-3 gap-0">
    <div class="col">
        <h6 class="title best-selling-title">Best Selling</h6>
    </div>
</div>


<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush bg-none">
                    @foreach ($popular_products as $product)
                    @php
                    // Get the first image from the images field, assuming it's a comma-separated string
                    $image_name = trim(explode(',', $product->images)[0], '"');
                    @endphp
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-50 border rounded-15">
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                        alt="{{ $product->name }}" />
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <p class="text-secondary size-10 mb-0">
                                    {{ DB::table('product_categories')->where('id',
                                    $product->category_id)->first()->name }}
                                </p>
                                <p>{{ $product->name }}</p>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="text-secondary text-muted size-10 mb-0">{{ $product->status }}</p>
                                <p>{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Swiper CSS (Add this to your <head>) -->
<link rel="stylesheet" href="{{ asset('assets/swiper/swiper-bundle.min.css') }}">

<!-- Swiper JS (Add this just before </body>) -->
<script src="{{ asset('assets/swiper/swiper-bundle.min.js') }}"></script>

<!-- Swiper Initialization -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper('.connectionwiper', {
            loop: true,  // Infinite loop
            autoplay: {
                delay: 3000,  // Auto slide every 3 seconds
                disableOnInteraction: false,  // Keep autoplay even after interaction
            },
            speed: 500,  // Transition speed (optional)
            slidesPerView: 'auto',  // Adjust for mobile
            spaceBetween: 10,  // Space between slides
        });
    });
</script>

<script>
    // Function to handle Enter key press and simulate button click
    function handleSearchEnter(event) {
        if (event.key === "Enter") {
            // Prevent default form submission (if it is inside a form)
            event.preventDefault();

            // Trigger the search button click programmatically
            document.getElementById("searchmainbtn").click();
        }
    }
</script>


<script>
    function toggleWishlist(productId, userId) {
        if (userId === 0) {
            showToast("Please log in to manage your wishlist.", "warning");
            return;
        }

        fetch(`/wishlist/toggle/${productId}`, {
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
                    let icon = document.getElementById(`heart-icon-${productId}`);
                    let button = document.getElementById(`favorite-button-${productId}`);

                    if (data.action === "added") {
                        icon.classList.remove("bi-heart");
                        icon.classList.add("bi-heart-fill");
                        button.classList.remove("bg-secondary");
                        button.classList.add("bg-danger");
                        showToast("Product added to favorites!", "success");
                    } else {
                        icon.classList.remove("bi-heart-fill");
                        icon.classList.add("bi-heart");
                        button.classList.remove("bg-danger");
                        button.classList.add("bg-secondary");
                        showToast("Product removed from favorites!", "info");
                    }
                } else {
                    showToast("Failed to update wishlist.", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast("Something went wrong. Please try again!", "error");
            });
    }

    function toggleMoreToWishlist(productId, userId) {
        if (userId === 0) {
            showToast("Please log in to manage your wishlist.", "warning");
            return;
        }

        fetch(`/wishlist/toggle/${productId}`, {
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
                    let icon = document.getElementById(`heart-icon-more-${productId}`);
                    let button = document.getElementById(`favorite-button-more-${productId}`);

                    if (data.action === "added") {
                        icon.classList.remove("bi-heart");
                        icon.classList.add("bi-heart-fill");
                        button.classList.remove("bg-secondary");
                        button.classList.add("bg-danger");
                        showToast("Product added to favorites!", "success");
                    } else {
                        icon.classList.remove("bi-heart-fill");
                        icon.classList.add("bi-heart");
                        button.classList.remove("bg-danger");
                        button.classList.add("bg-secondary");
                        showToast("Product removed from favorites!", "info");
                    }
                } else {
                    showToast("Failed to update wishlist.", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast("Something went wrong. Please try again!", "error");
            });
    }

    // Function to show toast notifications
    function showToast(message, type) {
        let bgColor = "";
        if (type === "success") bgColor = "green";
        if (type === "info") bgColor = "blue";
        if (type === "warning") bgColor = "orange";
        if (type === "error") bgColor = "red";

        let toast = document.createElement("div");
        toast.innerText = message;
        toast.style.cssText = `
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
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<script>
    function toggleWishlist(productId, userId) {
        if (userId === 0) {
            showToast("Please log in to manage your wishlist.", "warning");
            return;
        }

        fetch(`/wishlist/toggle/${productId}`, {
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
                    let icon = document.getElementById(`heart-icon-${productId}`);
                    let button = document.getElementById(`favorite-button-${productId}`);

                    if (data.action === "added") {
                        icon.classList.remove("bi-heart");
                        icon.classList.add("bi-heart-fill");
                        button.classList.remove("bg-secondary");
                        button.classList.add("bg-danger");
                        showToast("Product added to favorites!", "success");
                    } else {
                        icon.classList.remove("bi-heart-fill");
                        icon.classList.add("bi-heart");
                        button.classList.remove("bg-danger");
                        button.classList.add("bg-secondary");
                        showToast("Product removed from favorites!", "info");
                    }
                } else {
                    showToast("Failed to update wishlist.", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast("Something went wrong. Please try again!", "error");
            });
    }

    // Function to show toast notifications
    function showToast(message, type) {
        let bgColor = "";
        if (type === "success") bgColor = "green";
        if (type === "info") bgColor = "blue";
        if (type === "warning") bgColor = "orange";
        if (type === "error") bgColor = "red";

        let toast = document.createElement("div");
        toast.innerText = message;
        toast.style.cssText = `
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
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<script>

    // Function to shuffle images in the container
    function shuffleImages(containerId) {
        const container = document.getElementById(containerId);
        const images = Array.from(container.getElementsByTagName('img'));

        // Randomize the images using Fisher-Yates Shuffle
        for (let i = images.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [images[i].style.order, images[j].style.order] = [images[j].style.order, images[i].style.order];
        }
    }

    // Event listener for hovering over each product
    
    document.querySelectorAll('.card-body figure.avatar').forEach(product => {
        product.addEventListener('mouseenter', function () {
           
            const productId = this.querySelector('.product-image').id.split('-')[2];
            const imagesContainerId = `additional-images-${productId}`;
            
            shuffleImages(imagesContainerId);
        });
    });
</script>


<script>

    // Function to show toast notifications
    function showToast(message, type) {
        let bgColor = "";
        if (type === "success") bgColor = "green";
        if (type === "info") bgColor = "blue";
        if (type === "warning") bgColor = "orange";
        if (type === "error") bgColor = "red";

        let toast = document.createElement("div");
        toast.innerText = message;
        toast.style.cssText = `
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
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<script>
    // Function to shuffle images in the container
    function shuffleImages(containerId) {
        const container = document.getElementById(containerId);
        const images = Array.from(container.getElementsByTagName('img'));

        // Randomize the images using Fisher-Yates Shuffle
        for (let i = images.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [images[i].style.order, images[j].style.order] = [images[j].style.order, images[i].style.order];
        }
    }

    // Event listener for hovering over each product
    document.querySelectorAll('.card-body figure.avatar').forEach(product => {
        product.addEventListener('mouseenter', function () {
            const productId = this.querySelector('.product-image').id.split('-')[2];
            const imagesContainerId = `additional-images-${productId}`;
            shuffleImages(imagesContainerId);
        });
    });
</script>

@endSection