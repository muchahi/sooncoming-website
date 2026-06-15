@extends('layouts.inside')
@section('title', 'Address Selection')
@section('content')
<div class="main-container container">
    <!-- addresss -->
    <div class="row mb-3">
        <div class="col align-self-center">
            <h6 class="title">Delivery Address</h6>
        </div>
        
    </div>

    <!-- selected address -->
    <?php
    $myaddresses = DB::table('shipping_addresses')->where('user_id', Auth::user()->id ?? 0)->get();
    ?>
    <div class="row mb-2">
        @if($myaddresses->count() > 0)
            @foreach($myaddresses as $adr)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col align-self-center">
                                    <h6 class="mb-0">{{ Auth::user()->name }}<br />
                                        <span class="text-secondary size-12 fw-light">Primary</span>
                                    </h6>
                                </div>
                                <div class="col-auto align-self-center">
                                    <a href="addaddress" class="btn btn-44 btn-light"><i class="bi bi-pencil "></i></a>
                                    <a href="addaddress" class="btn btn-44 btn-light"><i class="bi bi-plus size-24"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="assets/img/map@2x.png" alt="" class="mw-100 mb-3" />
                            <div class="row">
                                <div class="col text-secondary">
                                    {{ $adr->address_line_1 }} {{ $adr->city }},<br>{{ $adr->state }} - {{ $adr->postal_code }}
                                </div>
                                <div class="col-auto text-end">
                                    <i class="bi bi-arrow-up-right-circle text-color-theme size-22"></i><br>
                                    <small class="text-secondary">{{ $adr->city }}<i class="bi bi-geo-alt"></i></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 col-md-6 col-lg-6">
                <p>You don't have an address yet. Please add one below:</p>
 <form action="{{ url('/addaddress') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="address_line_1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="123 Main St" required>
                <div class="invalid-feedback">
                    Please provide a valid address.
                </div>
            </div>

            <div class="mb-3">
                <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
                <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Apartment, suite, etc.">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                <div class="invalid-feedback">
                    Please provide a city.
                </div>
            </div>

           
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
                <div class="invalid-feedback">
                    Please provide a country.
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-rounded shadow-sm">Save Address</button>
            </div>
        </form>
            </div>
        @endif
    </div>

    @if($myaddresses->count() > 0)
        <!-- pricing -->
        <div class="row mb-4">
            <div class="col align-self-center">
                <h6 class="title">Pricing</h6>
            </div>
        </div>

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

        <div class="row mb-4">
            <div class="col-12">
                <a href="payment" class="btn btn-default shadow-sm btn-lg w-100 btn-rounded">Payment</a>
            </div>
        </div>
    @endif
</div>
@endsection
