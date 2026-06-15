@extends('layouts.inside')

@section('title', 'Payment Success')
@section('content')

    @if ($order)
          <div class="container text-center mt-5">
        <h1>Order Successful</h1>
        <p>{{ session('status') }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
    </div>
    @else
      <div class="container text-center mt-5">
        <h1>Payment Successful</h1>
        <p>{{ session('status') }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
    </div>
    @endif
  
@endsection
