@extends('admin.layouts.main')

@section('content')
@if(auth()->user()->is_admin)
<div class="container py-4 {{ session('dark_mode') ? 'bg-dark text-light' : 'bg-light text-dark' }}">
    <!-- Header Section -->
    
    
    <!-- 🔻 Place the alert block right here -->
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
    <!-- 🔺 End of alert messages -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Live Orders</h3>
        <form action="{{ route('toggle.darkmode') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                {{ session('dark_mode') ? 'Light Mode' : 'Dark Mode' }}
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <h3 class="text-primary fw-bold">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Pending</h5>
                    <h3 class="text-warning fw-bold">{{ $totalPending }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Dispatch</h5>
                    <h3 class="text-success fw-bold">{{ $totalDispatched }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Dropdown -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Orders</h5>
        <div class="dropdown">
            <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                {{ ucfirst($currentFilter) }} Orders
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.orders.liveorders', ['filter' => 'today']) }}">Today</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.orders.liveorders', ['filter' => 'yesterday']) }}">Yesterday</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.orders.liveorders', ['filter' => 'week']) }}">This Week</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment</th>
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
                                <small class="text-muted">
                                    <strong>Phone:</strong> {{ $order->user->phone }}
                                </small><br>
                                <small class="text-muted">
                                    <strong>Email:</strong> {{ $order->user->email }}
                                </small>
                            @endif
                        </td>
                        <td>KES {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'info' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
      
                <td>{{ $order->created_at->diffForHumans() }}</td>

                        <td>
                           
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('orders.action', $order->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="action" value="cancel_order">
                                            <button type="submit" class="dropdown-item">Cancel Order</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('orders.action', $order->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="action" value="cancel_product">
                                            <button type="submit" class="dropdown-item text-danger">Cancel Product</button>
                                        </form>
                                    </li>
                                    <li>
                            <!-- Trigger Button -->
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#messageModal" 
                                        data-order-id="{{ $order->id }}">
                                    Send Message
                                </button>
                               

                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Products under order -->
                    @if($order->orderProducts && $order->orderProducts->count())
                        <tr>
                            <td colspan="7">
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
                                                    <div class="me-3">
                                                        <img src="{{ asset('product_images/' . $image_name) }}" alt="Product Image" class="img-thumbnail" style="width: 60px; height: 60px;">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                                        <p class="mb-0">Price: KES {{ number_format($item->product->price ?? 0, 2) }} | Qty: {{ $item->quantity }}</p>
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
                        <td colspan="7" class="text-center text-muted">No orders found for selected filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Listen for when the modal is shown
    var messageModal = document.getElementById('messageModal');
    messageModal.addEventListener('show.bs.modal', function(event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget;
        
        // Extract order ID from data-* attribute of the button
        var orderId = button.getAttribute('data-order-id');
        
        // Set the order_id input field value in the form dynamically
        document.getElementById('orderIdInput').value = orderId;

        // Update form action dynamically (optional)
        var formAction = '{{ route("orders.action", ":id") }}';
        formAction = formAction.replace(':id', orderId);
        document.getElementById('sendMessageForm').action = formAction;
    });
});

</script>

@else
<span class="text-muted">This page is only available to Admins</span>
@endif
@endsection
