@extends('layouts.main')

@section('title', 'Order Summary')

@section('content')
<div class="container mt-4">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.track') ? 'active' : '' }}" 
               href="{{ route('orders.track', $order->id) }}">
               Delivery Info
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" 
               href="{{ route('orders.summary', $order->id) }}">
               Order Summary
            </a>
        </li>
    </ul>

    <!-- Order Summary Details -->
    <div class="row">
        <!-- Shipping Details -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <h5 class="card-title">Shipping Information</h5>
                   <p class="mb-1"><strong>Phone:</strong> {{ $shippingAddress->user->phone ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $shippingAddress->user->email ?? 'N/A' }}</p>

                    <p class="mb-1"><strong>Address:</strong> 
                        {{ $shippingAddress->address_line_1 ?? 'N/A' }}, 
                        {{ $shippingAddress->city ?? '' }}, 
                        {{ $shippingAddress->country ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="col-12">
            <div class="card shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <h5 class="card-title">Order #{{ $order->id }}</h5>
                    <p class="mb-1"><strong>Order Status:</strong> 
                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                    </p>
                    <p class="mb-1"><strong>Total Amount:</strong> 
                        KES {{ number_format($order->total_amount, 2) }}
                    </p>
                    <p class="mb-1"><strong>Payment Status:</strong> 
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Products in the Order -->
        <div class="col-12 mt-4">
            <h5 class="mb-3">Ordered Items</h5>
            @foreach($order->orderProducts as $item)
                @php
                    $image_name = isset($item->product->images) 
                        ? trim(explode(',', $item->product->images)[0], '"') 
                        : $item->product->image ?? 'default-image.jpg';
                @endphp
                <div class="card mb-3 shadow-sm rounded-lg border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar avatar-80 rounded-15 border me-3">
                            <img src="{{ asset('product_images/' . $image_name) }}" alt="Product Image" class="w-100">
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                            <p class="mb-0">Price: KES {{ number_format($item->product->price ?? 0, 2) }}</p>
                            <p class="mb-0">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($order->orderProducts->isEmpty())
                <p class="text-muted text-center">No items found for this order.</p>
            @endif
        </div>
    </div>
</div>
@endsection
