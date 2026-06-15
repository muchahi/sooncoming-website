@extends('layouts.email')

@section('title', 'New Merchant Onboarded')

@section('header', 'Welcome New Merchant!')

@section('content')
    <p>Hello Team,</p>
    <p>A new merchant has been onboarded:</p>
    <ul>
        <li><strong>Business Name:</strong> {{ $merchant['business_name'] }}</li>
        <li><strong>Location:</strong> {{ $merchant['location'] }}</li>
        <li><strong>Payment Methods:</strong> {{ implode(', ', json_decode($merchant['payment_methods'])) }}</li>
        <li><strong>Business Category:</strong> {{ $merchant['business_category'] }}</li>
        <li><strong>Drop Zone:</strong> {{ $merchant['drop_zone'] }}</li>
        <li><strong>Shop Unique Link:</strong> {{ $merchant['shop_unique_link'] }}</li>
    </ul>
    <p>Best Regards,<br>Your Company</p>
@endsection
