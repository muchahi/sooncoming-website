@extends('layouts.main')

@section('content')
    {{-- help me add search --}}
    {{-- Search Form --}}
    <div class="row mb-1">
        <div class="col-7">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="input-group mb-3">
                    <input type="text" name="q" class="form-control " placeholder="Search products..."
                        aria-label="Search products" aria-describedby="button-addon2" value="{{ request('q') }}">
                    <button class="btn btn-outline-success" type="submit" id="button-addon2">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <div class="col-5 d-flex justify-content-end">
            <nav>
                <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                   <button class="btn btn-44 btn-outline-dark active text-normalcase" id="nav-thumbnails-tab"
        data-bs-toggle="tab" data-bs-target="#nav-thumbnails">
    <i class="bi bi-grid"></i>
</button>
<button class="btn btn-44 btn-outline-dark ms-2 text-normalcase" id="nav-lists-tab"
        data-bs-toggle="tab" data-bs-target="#nav-lists">
    <i class="bi bi-list"></i>
</button>
                </div>
            </nav>
        </div>
        <div class="col-12 text-center mt-3">
            <p class="text-secondary">Checkout thumbnails view and list view of all products</p>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="nav-thumbnails" role="tabpanel">
            <div class="row mb-2">
                @foreach ($products as $product)
                    @php
                        $image_name = trim(explode(',', $product->images)[0], '"');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card mb-3">
                            <div class="card-body p-1 position-relative">
                                @if ($product->discount_percentage > 0)
                                    <div class="position-absolute start-0 top-0 m-2 z-index-1">
                                        <div class="tag tag-small bg-theme text-white">
                                            {{ $product->discount_percentage }}% OFF
                                        </div>
                                    </div>
                                @endif
                                <div class="position-absolute end-0 top-0 p-2 z-index-1 ">
                             <button id="favorite-button-{{ $product->id }}"
    onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
    class="btn btn-sm btn-26 rounded-circle shadow-sm shadow-danger text-white bg-danger">
    <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
</button>


                         

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
                             </button>
                                </div>
                                <figure class="avatar w-100 rounded-15 border">
                                    <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                        alt="" class="w-100">
                                </figure>
                            </div>
                            <div class="card-body pt-2">
                                <div class="row">
                                    <div class="col">
                                        <p class="small"><small
                                                class="text-muted size-12">{{ $product->name }}</small><br />KSH
                                            {{ number_format($product->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="col-auto px-0">
                                        <button onclick="addToCart({{ $product->id }})"
                                            class="btn btn-sm btn-link text-color-theme">
                                            <i class="bi bi-bag-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="nav-lists" role="tabpanel" aria-labelledby="nav-lists-tab">
            <div class="row mb-2">
                @foreach ($products as $product)
                    @php
                        $image_name = !empty($product->images) ? trim(explode(',', $product->images)[0], '"') : 'default.jpg';
                    @endphp
                    <div class="col-12 col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto position-relative">
                                        <div class="position-absolute end-0 top-0 px-2 py-1 mx-2 z-index-1">
                   <button id="favorite-button-{{ $product->id }}"
    onclick="toggleWishlist({{ $product->id }}, {{ Auth::user()->id ?? 0 }})"
    class="btn btn-sm btn-26 rounded-circle shadow-sm shadow-danger text-white bg-danger">
    <i class="bi bi-heart size-10 vm" id="heart-icon-{{ $product->id }}"></i>
</button>




                                        </div>
                                        <figure class="avatar avatar-80 rounded-15 border">
                                            <img src="{{ env('APP_ASSETS') }}/product_images/{{ $image_name }}"
                                                alt="{{ $product->name }}" class="w-100">
                                        </figure>
                                    </div>
                                    <div class="col position-relative">
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
                                            <i class="bi bi-bag-plus"></i> Add to Cart
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
@endsection
