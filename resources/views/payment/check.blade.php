
@extends('layouts.inside')

@section('content')
    <div class="container">
        <h3>Payment Approval</h3>
        <p>Please approve your payment on your phone. You will be notified when it's successful.</p>

        <button id="checkStatusBtn" class="btn btn-primary">Check Payment Status</button>
    </div>

    <script>
        // Simulate checking the payment status
        document.getElementById('checkStatusBtn').addEventListener('click', function() {
            fetch("{{ route('payment.status', ['order_id' => $order->id]) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ order_id: {{ $order->id }} })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'approved') {
                    window.location.href = "{{ route('payment.success') }}";
                } else {
                    window.location.href = "{{ route('payment.fail') }}";
                }
            });
        });
    </script>
@endsection
