@extends('layouts.main')
@section('name', 'Add shipping address')
@section('content')

<div class="row mb-10">
    <div class="col-12">
        <h5 class="mb-3" style="margin-left:3px;">Add Shipping Address</h5>
        <form action="{{ url('/addaddress') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="address_line_1" class="form-label" style="margin-left:3px;">Address Line 1</label>
                <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="123 Main St" required>
                <div class="invalid-feedback">
                    Please provide a valid address.
                </div>
            </div>

            <div class="mb-3">
                <label for="address_line_2" class="form-label" style="margin-left:3px;">Address Line 2 (Optional)</label>
                <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Apartment, suite, etc.">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label" style="margin-left:3px;">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                <div class="invalid-feedback">
                    Please provide a city.
                </div>
            </div>

            
          

            

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-rounded shadow-sm">Save Address</button>
                <br></br>
            </div>
        </form>
    </div>
</div>

@endsection
