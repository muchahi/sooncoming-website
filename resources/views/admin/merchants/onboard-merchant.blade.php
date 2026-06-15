@extends('admin.layouts.main')
@section('title', 'Oboard New Merchant')

@section('content')
@if(auth()->user()->is_admin)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@yield('title')</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.merchant.onboard') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" placeholder="Merchant Name"
                                    autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input id="phone_number" type="text"
                                    class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                    name="phone_number" value="{{ old('phone_number') }}" required
                                    placeholder="phone_number" autofocus>

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="email" type="text"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address"
                                    autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input id="location" type="text"
                                    class="form-control form-control-sm @error('location') is-invalid @enderror"
                                    name="location" value="{{ old('location') }}" required placeholder="Business Location"
                                    autocomplete="location">

                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="payment_methods" type="text"
                                    class="form-control form-control-sm @error('payment_methods') is-invalid @enderror"
                                    name="payment_methods" value="{{ old('payment_methods') }}" required
                                    autocomplete="payment_methods" placeholder="payment methods" autofocus>

                                @error('payment_methods')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input id="business_name" type="text"
                                    class="form-control form-control-sm @error('business_name') is-invalid @enderror"
                                    name="business_name" value="{{ old('business_name') }}" required
                                    autocomplete="business_name" placeholder="Business Name"
                                    placeholder="business_name Address" autofocus>

                                @error('business_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">



                            <div class="col-md-6">
                                <input id="drop_zone" type="drop_zone"
                                    class="form-control form-control-sm @error('drop_zone') is-invalid @enderror"
                                    name="drop_zone" value="{{ old('drop_zone') }}" required
                                    placeholder="Business Drop Zone" autocomplete="drop_zone">

                                @error('drop_zone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="business_category" type="business_category"
                                    class="form-control form-control-sm @error('business_category') is-invalid @enderror"
                                    name="business_category" value="{{ old('business_category') }}" required
                                    placeholder="Business Category" autocomplete="business_category">

                                @error('business_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" placeholder="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control form-control-sm"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="confirm_password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register New Merchant') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <span class="text-muted">This page is only available to Admins</span>
    @endif
@endsection
