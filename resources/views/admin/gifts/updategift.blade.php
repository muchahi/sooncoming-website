@extends('admin.layouts.main')

@section('content')
<div class="container py-4 {{ session('dark_mode') ? 'bg-dark text-light' : 'bg-light text-dark' }}">
    <!-- Header Section -->
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
                    <h3 class="text-primary fw-bold">47</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Pending</h5>
                    <h3 class="text-warning fw-bold">56</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Dispatch</h5>
                    <h3 class="text-success fw-bold">26</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Orders</h5>
        <div class="dropdown">
            <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Recent Orders
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">Yesterday</a></li>
                <li><a class="dropdown-item" href="#">This Week</a></li>
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
                        <td class="d-flex align-items-center gap-2">
                            <img src="{{ $order->user->avatar ?? 'https://via.placeholder.com/40' }}" class="rounded-circle" width="40" height="40" alt="Avatar">
                            <span>{{ $order->user->name ?? 'Guest' }}</span>
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
                                    <li><a class="dropdown-item" href="#">Cancel</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Cancel Product</a></li>
                                    <li><a class="dropdown-item" href="#">Message</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No orders found for selected filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 