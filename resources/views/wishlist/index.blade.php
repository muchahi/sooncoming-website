@extends('layouts.main')

@section('content')

@php 
$favourites = DB::table('wishlists')
    ->where('user_id', Auth::id()) // Shorter way to get user ID
    ->orderBy('created_at', 'desc') // Order by latest
    ->limit(10) // Get only the latest 10
    ->get();
@endphp

    <div class="row mb-1">
    
        <div class="col-md-9">
          
            
            
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="nav-thumbnails" role="tabpanel">
                        <div class="row">
                        @foreach ($favourites as $fav)
                            @php
                                $product = DB::table('products')->where('id', $fav->product_id)->first();
                                $image_name = !empty($product->images) ? trim(explode(',', $product->images)[0], '"') : 'default.jpg';
                            @endphp
                            
                           <div class="col-12 col-md-6" onclick="window.location.href='#'">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto position-relative" >
                                                <div class="position-absolute end-0 top-0 px-2 py-1 mx-2 z-index-1">
                                               <a href="{{ route('wishlist.remove', ['product' => $product->id]) }}" class="btn btn-sm btn-light rounded-circle text-danger position-absolute top-0 end-0 m-1">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                                </div>
                                                <figure class="avatar avatar-80 rounded-15 border">
                                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                                        alt="{{ $product->name }}" class="w-100">
                                                </figure>
                                            </div>
                                            <div class="col position-relative"  onclick="window.location.href='products/{{$product->id}}'">
                                                @if ($product->discount_percentage > 0)
                                                    <div class="position-absolute end-0 top-0 z-index-1">
                                                        <div class="tag tag-small bg-theme me-2">
                                                            {{ $product->discount_percentage }}% OFF
                                                        </div>
                                                    </div>
                                                @endif
                                                <p class="mb-0">
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
