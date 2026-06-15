<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin || @yield('title')</title>
    <!-- plugins:css -->
    <!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet"
        href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
    <link rel="stylesheet"
        href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css"
        href="{{ env('APP_ASSETS') }}/admin_assets/assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ env('APP_ASSETS') }}/admin_assets/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ env('APP_ASSETS') }}/admin_assets/assets/images/favicon.png" />
    {{-- toastr --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- drop zone --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
    <!--font awesome-->
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>


</head>

<?php  
    use Illuminate\Support\Facades\DB;
    $giftCard = DB::table('gift_card')->where('image_id', 1)->first(); 
?>

<body>
    @include('components.script')
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo me-5" href="index.html"><img
                        src="{{ env('APP_ASSETS') }}/logos/long_logo.png" class="me-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img
                        src="{{ env('APP_ASSETS') }}/logos/short_logo.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                            data-bs-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="ti-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> Private message </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="ti-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> 2 days ago </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            id="profileDropdown">
                            <img src="{{ env('APP_ASSETS') }}/user.png" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="ti-settings text-primary"></i> Settings </a>
                            <a class="dropdown-item">
                                <i class="ti-power-off text-primary"></i> Logout </a>
                        </div>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="icon-ellipsis"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Merchants -->
        <li class="nav-item">
           
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Merchants</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.merchant.add') }}">Add New Merchant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.merchants') }}">List Merchants</a>
                    </li>
                    
                </ul>
            </div>
        </li>

        <!-- Users -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Manage Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">List Users</a>
                    </li>
                </ul>
            </div>
        </li>
       <!-- Offers -->
    <!-- Offers -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#offers" aria-expanded="false" aria-controls="offers">
            <i class="fas fa-tags me-2"></i>
            <span class="menu-title">Offers</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="offers">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.offers.discounts') }}">Discounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gift-card.edit', $giftCard->image_id) }}">Gifts</a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Orders -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="orders">
            <i class="fas fa-shopping-bag me-2"></i> <!-- Added spacing -->
            <span class="menu-title">Orders</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="orders">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.orders.liveorders')}}">Live Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.orders.history')}}">Order History</a>
                </li>
            </ul>
        </div>
    </li>


        <!-- Products -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#product_manage" aria-expanded="false" aria-controls="product_manage">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Manage Products</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product_manage">
                
                
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                       
                        <a class="nav-link" href="{{ url('admin/product/add') }}">Add New Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/category/create') }}">Add New Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.type') }}">Add New Type</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">List Products</a>
                    </li>
                    
                </ul>
                
            </div>
        </li>

        <!-- Locations -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Manage Locations</span>
                <i class="menu-arrow"></i>
            </a>
           
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.index') }}">View All Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.create') }}">Add New Location</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.edit', 1) }}">Edit Location</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations.show', 1) }}">Location Details</a>
                    </li>
                    
                </ul>
            </div>
        </li>

        <!-- Quick Links -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                <i class="icon-ban menu-icon"></i>
                <span class="menu-title">Quick Links</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ env('MERCHANT_LINK') }}">Merchant Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ env('APP_URL') }}">User Website</a>
                    </li>
                </ul>
            </div>
        </li>


         <!--About us images-->
         
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#aboutSection" aria-expanded="false" aria-controls="aboutSection">
            <i class="bi bi-info-circle menu-icon"></i> {{-- Icon for About Section --}}
            <span class="menu-title">About Section</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="aboutSection">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.upload.about.form') }}">
                        <i class="bi bi-card-image me-1"></i> About Us Images
                    </a>
                </li>
            </ul>
        </div>
    </li>


        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('custom.logout') }}">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
</nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                    <!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('orders.action', 'placeholder') }}" method="POST" id="sendMessageForm">
        @csrf
        @method('POST')
        
       
        <input type="hidden" name="action" value="send_message">
        <input type="hidden" name="order_id" id="orderIdInput">

        <div class="modal-header">
          <h5 class="modal-title" id="messageModalLabel">Send Message to Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="messageText" class="form-label">Message</label>
            <textarea name="message" class="form-control" id="messageText" rows="4" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
       
      </form>
    </div>
  </div>
</div>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025.
                            Soon Comming . All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="ti-heart text-danger ms-1"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/off-canvas.js"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/template.js"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/settings.js"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/dashboard.js"></script>
    <!-- <script src="{{ env('APP_ASSETS') }}/admin_assets/assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
</body>

</html>
