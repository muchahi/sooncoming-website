@extends('layouts.main')
@section('name', 'Edit Address')
@section('content')

<div class="container">
    <h5 class="mb-4">Edit Shipping Address</h5>
    <form action="{{ route('addresses.update', $address->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="address_line_1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1" 
                   value="{{ old('address_line_1', $address->address_line_1) }}" required>
            <div class="invalid-feedback">
                Please provide a valid address.
            </div>
        </div>

        <div class="mb-3">
            <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2" 
                   value="{{ old('address_line_2', $address->address_line_2) }}">
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" 
                   value="{{ old('city', $address->city) }}" required>
            <div class="invalid-feedback">
                Please provide a city.
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" 
                       value="{{ old('state', $address->state) }}" required>
                <div class="invalid-feedback">
                    Please provide a state.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" 
                       value="{{ old('postal_code', $address->postal_code) }}" required>
                <div class="invalid-feedback">
                    Please provide a postal code.
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" 
                   value="{{ old('country', $address->country) }}" required>
            <div class="invalid-feedback">
                Please provide a country.
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-rounded shadow-sm">Update Address</button>
        </div>
    </form>
</div>

@endsection
