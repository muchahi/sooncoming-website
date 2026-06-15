@extends('layouts.email')

@section('title', 'Welcome to Our Platform!')

@section('header', 'Welcome to Our Merchant Platform!')

@section('content')
    <p>Hello {{ $merchant['business_name'] }},</p>
    <p>We are excited to welcome you as a merchant on our platform. Below are the details of your business and login
        credentials:</p>

    <ul>
        <li><strong>Business Name:</strong> {{ $merchant['business_name'] }}</li>
        <li><strong>Location:</strong> {{ $merchant['location'] }}</li>
        <li><strong>Payment Methods:</strong> {{ implode(', ', json_decode($merchant['payment_methods'])) }}</li>
        <li><strong>Business Category:</strong> {{ $merchant['business_category'] }}</li>
        <li><strong>Drop Zone:</strong> {{ $merchant['drop_zone'] }}</li>
        <li><strong>Shop Unique Link:</strong> {{ $merchant['shop_unique_link'] }}</li>
    </ul>

    <p>Your login details are as follows:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user['email'] }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>We recommend changing your password after your first login for security purposes.</p>

    <p>You can log in to your account using the link below:</p>
    <p><a href="{{ url('/login') }}">Login Here</a></p>

    <p>If you have any questions, feel free to reach out to us.</p>
    <p>Best Regards,<br>Your Company Team</p>
@endsection
