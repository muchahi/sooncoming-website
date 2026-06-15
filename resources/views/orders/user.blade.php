@extends('layouts.main')

@section('title', 'My Orders')

@section('content')

    @php
        $userId = Auth::id();
        $orders = App\Models\Order::where('user_id', $userId)
                                  ->with('products') // Eager load products
                                  ->get();
    @endphp

    @if ($orders->isEmpty())
        <p class="text-center text-muted">You have no orders yet.</p>
    @else
        @foreach ($orders as $order)
            <div class="order-details mb-4 p-3 border rounded shadow-sm" id="order-{{ $order->id }}">
                <h5 class="mb-3">Order #{{ $order->id }} 
                    <span class="badge bg-{{ $order->status == 'paid' ? 'success' : ($order->status == 'shipped' ? 'primary' : 'secondary') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </h5>

                @foreach ($order->products as $product)
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-auto position-relative">
                                        @php
                                            // Retrieve product image
                                            $image_name = isset($product->images) 
                                                ? trim(explode(',', $product->images)[0], '"') 
                                                : $product->image ?? 'default-image.jpg';
                                        @endphp

                                        <figure class="avatar avatar-80 rounded-15 border">
                                            <img src="{{ asset('product_images/' . $image_name) }}" alt="Product Image" class="w-100">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center">
                                        <p class="mb-1">
                                            <strong>{{ $product->name }}</strong>
                                        </p>
                                        <h6>Price: KSH {{ number_format($product->pivot->price, 2) }}</h6>
                                        <p class="mb-1">
                                            @if ($product->discount_percentage > 0)
                                                <span class="text-success">{{ $product->discount_percentage }}% OFF</span> 
                                            @else
                                                <span class="text-muted">No Discount</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <a href="{{ route('orders.track', $order->id) }}" class="text-decoration-none">
                                            Track <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button onclick="cancelOrder({{ $order->id }})" 
                                            class="btn btn-sm btn-light rounded-circle text-danger">
                                        <i class="bi bi-trash"></i> 
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <script>
    function cancelOrder(orderId) {
        if (confirm("Are you sure you want to move this order to trash?")) {
            fetch(`/order/cancel/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let orderElement = document.getElementById(`order-${orderId}`);
                    if (orderElement) {
                        orderElement.remove();
                    }
                    alert(data.success);
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to move the order to trash.');
            });
        }
    }
    </script>

@endsection
