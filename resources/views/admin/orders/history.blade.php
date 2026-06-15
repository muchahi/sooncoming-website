@extends('admin.layouts.main')

@section('content')
 @if(auth()->user()->is_admin)
<div class="container py-4 {{ session('dark_mode') ? 'bg-dark text-light' : 'bg-light text-dark' }}">
    
    {{-- ✅ Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Order History</h3>
        
        {{-- 🔍 Search --}}
        <form action="{{ route('admin.orders.history') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search orders..." value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>

    {{-- ✅ Filter Tabs --}}
    <ul class="nav nav-tabs mb-3">
        @php
            $statuses = ['all', 'completed', 'cancelled', 'returned'];
        @endphp
        @foreach ($statuses as $status)
            <li class="nav-item">
                <a class="nav-link {{ request('status') === $status || (request('status') === null && $status === 'all') ? 'active' : '' }}"
                   href="{{ route('admin.orders.history', ['status' => $status]) }}">
                    {{ ucfirst($status) }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- ✅ Orders Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Delivery</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            <span>{{ $order->user->name ?? 'Guest' }}</span><br>
                            @if($order->user)
                                <small class="text-muted"><strong>Phone:</strong> {{ $order->user->phone }}</small><br>
                                <small class="text-muted"><strong>Email:</strong> {{ $order->user->email }}</small>
                            @endif
                        </td>
                        <td>KES {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($order->delivery_type ?? 'N/A') }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $order->status === 'completed' ? 'success' :
                                ($order->status === 'cancelled' ? 'danger' :
                                ($order->status === 'returned' ? 'secondary' : 'info')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->diffForHumans() }}</td>
                        <td>
                            
                            
                            {{-- ✅ Refund and Message actions --}}
                            @if($order->status === 'completed')
                                <a href="{{ route('admin.orders.refund', $order->id) }}" class="btn btn-sm btn-outline-danger">Refund</a>
                            @elseif($order->status === 'cancelled' || $order->status === 'returned')
                                <button class="btn btn-sm btn-outline-danger" disabled>Refund</button>
                            @endif

                            <a href="{{ route('admin.orders.message', $order->id) }}" class="btn btn-sm btn-outline-primary ms-2">Send Message</a>
                           
                        </td>
                    </tr>

                    {{--  Products under order --}}
                    @if($order->orderProducts && $order->orderProducts->count())
                        <tr>
                            <td colspan="8">
                                <div class="p-3 border rounded bg-light">
                                    <div class="row">
                                        @foreach($order->orderProducts as $item)
                                            @php
                                                $image_name = isset($item->product->images) 
                                                    ? trim(explode(',', $item->product->images)[0], '"') 
                                                    : $item->product->image ?? 'default-image.jpg';
                                            @endphp
                                            <div class="col-md-4 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('product_images/' . $image_name) }}" alt="Product Image" class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                                        <p class="mb-0">
                                                            Price: KES {{ number_format($item->product->price ?? 0, 2) }} | 
                                                            Qty: {{ $item->quantity }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No orders found for the selected filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@else
<span class="text-muted">This page is only available to Admins</span>
 @endif
@endsection
