@extends('layouts.main')

@section('title', 'Order Tracking')

@section('content')
<style>
    .tracking-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 2fr;
        row-gap: 1.5rem;
        column-gap: 1rem;
        align-items: center;
    }

    .tracking-step {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        max-width: 100%;
        box-sizing: border-box;
    }

    .tracking-icon {
        width: 60px;
        height: 60px;
        font-size: 20px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 100%;
    }

    .emoji {
        font-size: 2.5rem;
        text-align: center;
        max-width: 100%;
    }

    .tracking-description {
        font-size: 1rem;
        text-align: left;
        display: flex;
        align-items: center;
        height: 100%;
        justify-content: flex-start;
        max-width: 100%;
    }

    

    .tracking-description h6 {
        font-size: 1.2rem;
        margin-bottom: 4px;
    }

    .vertical-line {
        width: 2px;
        height: 70px;
        background-image: linear-gradient(to bottom, #000 30%, transparent 30%);
        background-size: 2px 8px;
        background-repeat: repeat-y;
        margin: 4px auto 0;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    @keyframes glow {
        0% { box-shadow: 0 0 5px rgba(0, 123, 255, 0.7); }
        50% { box-shadow: 0 0 15px rgba(0, 123, 255, 1); }
        100% { box-shadow: 0 0 5px rgba(0, 123, 255, 0.7); }
    }

    .animate-bounce {
        animation: bounce 1.2s infinite;
    }

    .animate-glow {
        animation: glow 1.5s infinite;
    }

    /* RESPONSIVE TWEAKS ONLY — NO LAYOUT CHANGES */
    @media (max-width: 767px) {
        .tracking-icon {
            width: 45px;
            height: 45px;
            font-size: 16px;
        }

        .emoji {
            font-size: 1.8rem;
        }

        .tracking-description {
            font-size: 0.9rem;
        }

        .tracking-description h6 {
            font-size: 1rem;
        }

        .vertical-line {
            height: 70px;
        }
    .tracking-grid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    }

    section {
        padding-bottom: 60px;
    }

    footer {
        margin-top: 20px;
    }

    .text-center {
        margin-bottom: 0 !important;
    }

    .tracking-container {
        padding-top: 50px;
        padding-bottom: 50px;
        padding-left: 15px;
        padding-right: 15px;
    }
</style>
<!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.track') ? 'active' : '' }}" 
               href="{{ route('orders.track', $order->id) }}">
               Delivery Info
            </a>
        </li>
        @if($order->status == 'delivered')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.summary') ? 'active' : '' }}" 
               href="{{ route('orders.summary', $order->id) }}">
               Order Summary
            </a>
        </li>
        @endif
    </ul>

<section class="tracking-container my-5 p-3 shadow rounded bg-white container-fluid" style="max-width: 1100px; margin: auto;">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark" style="font-size: 1.6rem;">ORDER TRACKING</h2>
        <p class="text-muted mb-1" style="font-size: 1rem;">Order ID: {{ $order->id ?? '#123456' }}</p>
        <h3 class="fw-bold text-danger animate__animated animate__pulse animate__infinite" style="font-size: 1.5rem;">SoonComming</h3>
    </div>

    @php
        $orderStatus = $order->status ?? 'shipped';
        $estimatedDeliveryDate = isset($order->estimated_delivery_date)
            ? \Carbon\Carbon::parse($order->estimated_delivery_date)->format('F d, Y, h:i A')
            : 'TBD';
    @endphp

    <div class="tracking-grid">
        @if($orderStatus == 'pending')
        <!-- Order Placed -->
        <div class="tracking-step d-flex flex-column align-items-center">
            <div class="tracking-icon {{$orderStatus == 'pending'? 'bg-warning animate-glow' : ''}}">✓</div>
            <div class="vertical-line"></div>
        </div>
        <div class="tracking-step">
            <div class="emoji">🎁</div>
        </div>
        <div class="tracking-step tracking-description">
            <div>
                <h6 class="fw-bold">Order Placed</h6>
                <p class="text-muted mb-1">Your order has been placed successfully.</p>
                <p class="text-muted">Estimated Time: <strong>2 Days</strong></p>
            </div>
        </div>

        @elseif($orderStatus == 'waiting_for_delivery')
        <!-- On the Way -->
        <div class="tracking-step d-flex flex-column align-items-center">
            <div class="tracking-icon {{$orderStatus == 'waiting_for_delivery'? 'bg-info animate-glow': ''}}">✓</div>
            <div class="vertical-line"></div>
        </div>
        <div class="tracking-step">
            <div class="emoji">
                🚚<br><small class="text-muted" style="font-size: 0.65rem;">Sooncomming</small>
            </div>
        </div>
        <div class="tracking-step tracking-description">
            <div>
                <h6 class="fw-bold">On the Way</h6>
                <p class="text-muted mb-1">Your order is on the way.</p>
                <p class="text-muted">Estimated Time: <strong>1 Day</strong></p>
            </div>
        </div>

        @elseif($orderStatus == 'delivered')
        <!-- Delivered -->
        <div class="tracking-step d-flex flex-column align-items-center">
            <div class="tracking-icon {{$orderStatus == 'delivered'? 'bg-success animate-glow':'' }}">✓</div>
        </div>
        <div class="tracking-step">
            <div class="emoji"></div>
        </div>
        <div class="tracking-step tracking-description">
            <div>
               
                <h6 class="fw-bold">Product Delivered</h6>
                 @if($orderStatus == 'delivered')
                <p class="text-muted mb-1">Delivered on:</p>
                <p class="text-muted fw-bold text-primary">{{ $deliveredDate ?? $estimatedDeliveryDate }}</p>
                @else
                 <p class="text-muted mb-1">Expected on:</p>
               <p class="text-muted fw-bold text-primary">{{ $estimatedDeliveryDate }}</p>
                @endif
            </div>
        </div>
       
        
     @endif   
    
          
        
    </div> 
    
     

    
    <!-- Footer -->
    <div class="mt-1 text-center">
        <p class="text-muted mb-1" style="font-size: 0.9rem;">Reach Amos:</p>
        <p class="fw-bold mb-0" style="font-size: 1rem;">Phone: +254704136678</p>
        <p class="fw-bold mb-0" style="font-size: 1rem;">Email: shop@sooncomming.co.ke</p>
    </div>
 
   

</section>
@endsection
