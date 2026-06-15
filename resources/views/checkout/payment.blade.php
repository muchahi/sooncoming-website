@extends('layouts.inside')

@section('title', 'Payment Details')
@section('content')

<?php

$lastAddress = DB::table('shipping_addresses')
    ->where('user_id', Auth::user()->id)
    ->latest()
    ->first(); 

$addressId = request()->query('selected_address_id') ?? $lastAddress->id;




?>

  <script>
        function selectPaymentMode(element) {
            // Remove active class from all payment options
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('active');
            });

            // Add active class to the selected option
            element.classList.add('active');

            // Set the selected payment method in the hidden input field
            document.getElementById('paymentMethod').value = element.getAttribute('data-mode');
        }
    </script>

    <style>
        .payment-option.active {
            border: 2px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>


    <!-- Address -->
    <div class="row mb-3">
        <div class="col align-self-center">
            <h6 class="title">Payment Details</h6>
        </div>
        <div class="col-auto">
            <a href="index.html" class="small">Offers <i class="bi bi-chevron-right vm"></i></a>
        </div>
    </div>

    <!-- Coupon Code -->
    <div class="row mb-3">
        <div class="col-12 overflow-hidden">
            <div class="row">
                <div class="col position-relative align-self-center">
                    <div class="form-group form-floating mb-3 is-valid">
                        <input type="text" class="form-control" value="" id="coupon" placeholder="Coupon Code">
                        <label class="form-control-label" for="coupon">Coupon Code</label>
                    </div>
                </div>
                <div class="col-auto align-self-center">
                    <button class="btn btn-light btn-44 filter-btn">
                        <i class="bi bi-patch-check size-22"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modes -->
    <form action="{{ route('payment.process') }}" method="GET">
        @csrf
        <input type="hidden" value="{{$addressId}}" name="address_id">
        <div class="row mb-3">
            <div class="col align-self-center">
                <h6 class="title">Payment Modes</h6>
            </div>
        </div>
        <div class="row mb-2">
            <!-- Pay on Delivery -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm mb-3 text-normal payment-option" 
                     data-mode="pay_on_delivery" onclick="selectPaymentMode(this)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 p-0 shadow-sm shadow-warning rounded-15">
                                    <div class="icons bg-warning text-white rounded-12">
                                        <img src="{{ env('APP_ASSETS') }}/assets/img/maestro.png" alt="" class="vm mw-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <p>Pay on Delivery<br><small class="text-opac">Mpesa</small></p>
                            </div>
                            <div class="col-auto align-self-center">
                                <i class="bi bi-chevron-right text-color-theme"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pay Now -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm mb-3 text-normal payment-option active" 
                     data-mode="pay_now" onclick="selectPaymentMode(this)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 p-0 shadow-sm shadow-primary rounded-15">
                                    <div class="icons bg-primary text-white rounded-12">
                                        <img src="{{ env('APP_ASSETS') }}/assets/img/maestro.png" alt="" class="vm mw-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <p>Pay Now<br><small class="text-opac">Pay before</small></p>
                            </div>
                            <div class="col-auto align-self-center">
                                <i class="bi bi-chevron-right text-color-theme"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Input for Payment Mode -->
        <input type="hidden" value="pay_now" name="payment_mode" id="paymentMethod">

        <!-- Pricing -->
        <div class="row mb-4">
            <div class="col align-self-center">
                <h6 class="title">Pricing</h6>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <p>Shipping Cost</p>
            </div>
            <div class="col-auto">KSH {{env('DELIVERY_COST')}}</div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <p>Subtotal</p>
            </div>
            <div class="col-auto">KSH {{$subtotal}}</div>
        </div>
        <div class="row fw-bold mb-4">
            <div class="mb-3 col-12">
                <div class="dashed-line"></div>
            </div>
            <div class="col">
                <p>Total</p>
            </div>
            <div class="col-auto">KSH {{$subtotal+ env('DELIVERY_COST')}}</div>
        </div>
        <input name="amt" type="hidden" value="{{$subtotal+ env('DELIVERY_COST')}}">
        <div class="row mb-4">
            <div class="col-12">
                <button type="submit" class="btn btn-default shadow-sm btn-lg w-100 btn-rounded">Confirm Order</button>
            </div>
        </div>
    </form>
@endsection

