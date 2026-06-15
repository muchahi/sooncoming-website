@extends('layouts.main')

@section('title', 'Order History')

@section('content')
<div class="container">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="orderTabs">
        <li class="nav-item">
            <a class="nav-link active" id="products-tab" data-bs-toggle="tab" href="#products">Ordered Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders">Order Details</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3">
        <!-- Ordered Items Tab -->
        <div class="tab-pane fade show active" id="products">
            <div class="row mb-2">
                @forelse($orders as $order)
                    @foreach($order->orderProducts as $item)
                     @php
                        $image_name = isset($item->product->images) 
                            ? trim(explode(',', $item->product->images)[0], '"') 
                            : $item->product->image ?? 'default-image.jpg';
                    @endphp
                        <div class="col-12 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto pe-0 position-relative">
                                            <div class="avatar avatar-80 rounded-15 border">
                                                <img src="{{ asset('product_images/' . $image_name) }}" alt="Product Image" class="w-100">
                                            </div>
                                        </div>
                                        <div class="col align-self-center">
                                            <p class="mb-0">
                                                <small class="text-muted size-12">{{ $item->product->name ?? 'Unknown Product' }}</small>
                                            </p>
                                            <h5 class="mb-1">Ksh{{ number_format($item->product->price ?? 0, 2) }}</h5>
                                            <p class="size-10">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="col-12">
                        <p>No products found in your orders.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Order Details Tab -->
        <div class="tab-pane fade" id="orders">
            <div class="row mb-2">
    @forelse($orders as $order)
        <div class="col-12">
            <div class="card mb-3 shadow-sm rounded-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Order #{{ $order->id }}</h5>
                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }} text-dark">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><i class="bi bi-cash-coin text-success"></i> 
                                <strong>Amount:</strong> KES {{ number_format($order->total_amount, 2) }}
                            </p>
                            <p class="mb-1"><i class="bi bi-credit-card text-primary"></i> 
                                <strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            @php
                                $shipping = \App\Models\ShippingAddress::find($order->shipping_address);
                            @endphp
                            
                            <p class="mb-1"><i class="bi bi-house-door text-info"></i> 
                                <strong>Shipping:</strong> <small>
                                {{ $shipping->address_line_1 ?? 'N/A' }},
                                {{ $shipping->city ?? '' }},
                                {{ $shipping->country ?? '' }}
                                </small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><i class="bi bi-calendar-check text-secondary"></i> 
                                <strong>Ordered On:</strong> {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-3"><i class="bi bi-box-seam text-warning"></i> 
                                <strong>Delivery Status:</strong> {{ ucfirst($order->status) }}
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('orders.track', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-truck"></i> Track Order
                        </a>

                        @if($order->payment_status != 'paid')
                            <a href="{{ route('payment', $order->id) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-credit-card"></i> Pay Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mt-4">
            <p class="text-muted">No orders found.</p>
        </div>
    @endforelse
</div>

        </div>
    </div>
</div>
@endsection