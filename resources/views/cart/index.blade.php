@extends('layouts.main')

@section('content')

<div class="row mb-2 px-3" style="max-height: 100vh; overflow-y: auto;">
     @if($cartItems->count() > 0)
     <div class="row  mb-2 scrollable-cart" >
  
    @foreach ($cartItems as $item)
        @php
            $image_name = isset($item->product->images) 
                ? trim(explode(',', $item->product->images)[0], '"') 
                : $item->product->image ?? 'default-image.jpg';
        @endphp

        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto position-relative">
                            <a href="{{ route('cart.remove', ['id' => $item->id]) }}" class="btn btn-sm btn-light rounded-circle text-danger position-absolute top-0 end-0 m-1">
                                <i class="bi bi-trash"></i>
                            </a>
                            <img src="{{ asset('product_images/' . $image_name) }}" alt="{{ $item->product->name }}" class="rounded w-100" style="max-width: 80px;">
                        </div>
                        <div class="col">
                            <h6>{{ $item->product->name }}</h6>
                            <p class="mb-1">KSH {{ number_format($item->product->price, 2) }}</p>
                            @if ($item->product->discount_percentage > 0)
                                <p class="text-success">{{ $item->product->discount_percentage }}% OFF</p>
                            @endif
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantityInCart({{ $item->product->id }}, 'decrement')">-</button>
                                <span class="mx-2" id="item_quantity_{{ $item->product->id }}">{{ $item->quantity }}</span>
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantityInCart({{ $item->product->id }}, 'increment')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    @endforeach
    
 
</div>

    <!-- Pricing Details -->
    <div class="row mb-3">
        <div class="col">Shipping Cost</div>
        <div class="col-auto">KSH {{ env('DELIVERY_COST', 0) }}</div>
    </div>
    <div class="row mb-3">
        <div class="col">Subtotal</div>
        <div class="col-auto" id="subtotal">KSH {{ number_format($subtotal, 2) }}</div>
    </div>
    <div class="row fw-bold mb-4">
        <div class="col">Total</div>
        <div class="col-auto" id="totalamount">KSH {{ number_format($subtotal + env('DELIVERY_COST', 0), 2) }}</div>
    </div>
    
    <!-- Checkout Button -->
    <div class="row mb-4">
        <div class="col-12">
            @if(Route::has('checkout'))
                <a href="{{ route('address') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
            @endif
        </div>
    </div>
   @else 
    <div class="d-flex flex-column align-items-center justify-content-center text-center p-4" style="min-height: 300px;">
    
    <!-- Purple-Themed Cart Icon -->
    <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" alt="Empty Cart"
         style="width: 120px; opacity: 0.9; margin-bottom: 20px; animation: float 2s ease-in-out infinite;">

    <!-- Empty Cart Message -->
    <h5 class="fw-semibold" style="color: #5D3FD3;">Oops! Your cart is feeling empty</h5>
    <p style="color: #888;">Looks like you haven’t added anything yet.</p>

    <!-- Purple Start Shopping Button -->
    <a href="{{ url('/') }}" class="btn mt-3 px-4 py-2"
       style="background-color: #7E57C2; color: white; border-radius: 30px; box-shadow: 0 4px 10px rgba(126, 87, 194, 0.3);">
        Start Shopping
    </a>
</div>

  
    <style>
       @keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-6px);
  }
}
 
    </style>
    @endif
<script>
    function updateQuantityInCart(productId, action) {
        const quantityElement = document.getElementById(`item_quantity_${productId}`);
        let quantity = parseInt(quantityElement.innerText);

        // Ensure quantity is a valid number
        if (isNaN(quantity)) {
            toastr.error("Invalid quantity.");
            return;
        }

        // Check the action to determine whether to increment or decrement
        if (action === 'increment') {
            quantity++; // Increase quantity
        } else if (action === 'decrement' && quantity > 1) { // Ensure quantity doesn't go below 1
            quantity--; // Decrease quantity only if greater than 1
        } else {
            toastr.warning("Minimum quantity is 1.");
            return;
        }
        
        
        console.log(quantity);
        
    

        // Update the UI
        quantityElement.innerText = quantity;

        // Validate that the quantity is a valid integer before sending the request
        if (!Number.isInteger(quantity) || quantity < 1) {
            toastr.error("Invalid quantity.");
            return;
        }

        // Send the updated quantity to the server
        fetch('/cart/update', {
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
</script>
</div>
@endsection
