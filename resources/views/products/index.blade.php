@extends('layouts.main')

@section('content')
    <div class="row mb-1">
    
        <div class="col-md-9">
            <form method="GET" action="{{ route('products.user') }}">
                <div class="input-group mb-3">
                    <input type="hidden" name="c" value="{{ request('c') }}">
                    <input type="text" name="q" class="form-control" placeholder="Search products..." 
                        aria-label="Search products" aria-describedby="button-addon2" value="{{ request('q') }}">
                    <button class="btn btn-outline-success" type="submit" id="button-addon2">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
            
 
            
           <div>
            <div class="nav nav-tabs border-0  d-flex align-items-center" id="nav-tab" role="tablist">
                <button class="btn btn-44 btn-outline-dark active" id="nav-thumbnails-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-thumbnails" role="tab">
                    <i class="bi bi-grid"></i>
                </button>
                <button class="btn btn-44 btn-outline-dark ms-2" id="nav-lists-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-lists" role="tab">
                    <i class="bi bi-list"></i>
                </button>
        
                <!-- Float-right filter button -->
                <div class="ms-auto">
                    <button class="btn btn-light btn-44 filter-btn">
                        <i class="bi bi-filter size-22"></i>
                    </button>
                </div>
            </div>
        </div>
            
            
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="nav-thumbnails" role="tabpanel">
                    <div class="row">
                        @foreach ($products as $product)
                            @php
                                $image_name = trim(explode(',', $product->images)[0], '"');
                            @endphp
                            <div class="col-6 col-md-4 col-lg-3"  >
                                <div class="card mb-3">
                                    <div class="card-body p-1 position-relative">
                                        @if ($product->discount_percentage > 0)
                                            <div class="position-absolute start-0 top-0 m-2 z-index-1">
                                                <div class="tag tag-small bg-theme text-white">
                                                    {{ $product->discount_percentage }}% OFF
                                                </div>
                                            </div>
                                        @endif
                                        <div class="position-absolute end-0 top-0 p-2 z-index-1">
                                            <button id="favorite-button-{{ $product->id }}"
                                                onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
                                                class="btn btn-sm btn-26 rounded-circle shadow-sm bg-danger text-white">
                                                <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
                                            </button>
                                        </div>
                                        <figure onclick="window.location.href='products/{{$product->id}}'" class="avatar w-100 rounded-15 border">
                                            <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                                alt="" class="w-100">
                                        </figure>
                                    </div>
                                    <div class="card-body pt-2" >
                                        <div class="row">
                                            <div class="col" onclick="window.location.href='products/{{$product->id}}'">
                                                <p class="small">
                                                    <small class="text-muted size-12">{{ $product->name }}</small><br />
                                                    KSH {{ number_format($product->price, 2) }}
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
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-lists" role="tabpanel">
                    <div class="row">
                        @foreach ($products as $product)
                            @php
                                $image_name = !empty($product->images) ? trim(explode(',', $product->images)[0], '"') : 'default.jpg';
                            @endphp
                            
                           <div class="col-12 col-md-6" >
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto position-relative"  >
                                                <div class="position-absolute end-0 top-0 px-2 py-1 mx-2 z-index-1">
                                                    <button id="favorite-button-{{ $product->id }}"
                                                        onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
                                                        class="btn btn-sm btn-26 rounded-circle shadow-sm bg-danger text-white">
                                                        <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
                                                    </button>
                                                </div>
                                                <figure onclick="window.location.href='products/{{$product->id}}'" class="avatar avatar-80 rounded-15 border">
                                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                                        alt="{{ $product->name }}" class="w-100">
                                                </figure>
                                            </div>
                                            <div class="col position-relative" >
                                                @if ($product->discount_percentage > 0)
                                                    <div class="position-absolute end-0 top-0 z-index-1">
                                                        <div class="tag tag-small bg-theme me-2">
                                                            {{ $product->discount_percentage }}% OFF
                                                        </div>
                                                    </div>
                                                @endif
                                                <p class="mb-0" onclick="window.location.href='products/{{$product->id}}'" >
                                                    <small class="text-muted size-12">{{ $product->name }}</small>
                                                </p>
                                                <h5>KSH {{ number_format($product->price, 2) }}</h5>
                                                <button onclick="addToCart({{ $product->id }})"
                                                    class="btn btn-sm px-0 text-color-theme">
                                                    <i class="bi bi-cart"></i> Add to Cart
                                                </button>
                                            </div>
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
@endsection
