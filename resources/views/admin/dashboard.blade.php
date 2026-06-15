<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layouts.main')
@section('title', 'Dashboard Page')
@section('content')

    <?php
    // Overall analytics
    $total_users = DB::table('users')->count(); // More efficient than get()->count()
    $total_merchants = DB::table('users')->where('user_type', 'merchant')->count();
    $total_orders = DB::table('orders')->where('status', 'completed')->sum('total_amount');
    $total_profits = $total_orders * 0.2;
    
    // Today's analytics (assuming 'created_at' is available for date filtering)
    $todays_users = DB::table('users')
        ->whereDate('created_at', now()) // Fetch users created today
        ->count();
    
    $todays_merchants = DB::table('users')
        ->where('user_type', 'merchant')
        ->whereDate('created_at', now()) // Fetch merchants created today
        ->count();
    
    $todays_orders = DB::table('orders')
        ->where('status', 'completed')
        ->whereDate('created_at', now()) // Fetch orders completed today
        ->sum('total_amount');
    
    $todays_profits = $todays_orders * 0.2;
    
    $allProducts = DB::table('products')->count();
    $users = DB::table('users')->count();
    ?>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome {{ Auth::user()->name }}</h3>
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly!
                    </h6>
                </div>
                @if(auth()->user()->is_admin)
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                            <a class="btn btn-sm btn-light bg-white " href="{{ route('admin.merchant.add') }}">
                                <i class="mdi mdi-account-plus"></i> Add New Merchant
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12 grid-margin transparent">
            <div class="row">
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Today’s Profits</p>
                            <p class="fs-30 mb-2">{{ $todays_profits }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Todays Orders</p>
                            <p class="fs-30 mb-2">{{ $todays_orders }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4"> Profits Today</p>
                            <p class="fs-30 mb-2">{{ $todays_profits }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Total Profits</p>
                            <p class="fs-30 mb-2">{{ $total_profits }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Orders</p>
                            <p class="fs-30 mb-2">{{ $total_orders }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Profits</p>
                            <p class="fs-30 mb-2">{{ $total_profits }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Number of Products</p>
                            <p class="fs-30 mb-2">{{ $allProducts }}</p>
                            <p>0.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Number of Users</p>
                            <p class="fs-30 mb-2">{{ $users }}</p>
                            <p>0.22% (30 days)</p>
                        </div>
                        @else 
                        <span class="text-muted">This page is only available to Admins</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
