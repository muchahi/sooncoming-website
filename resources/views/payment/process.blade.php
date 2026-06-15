@extends('layouts.inside')

@section('content')
<?php 
$amt = request()->query('amt') ?? 0;
?>
<div tabindex="-1" class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center px-2" style="z-index: 1050; background-color: rgba(0,0,0,0.5);">
    <div class="p-3 w-100" style="max-width: 480px; background-color: #43B02A; border-radius: 1rem;">
        <div class="card shadow-lg p-3 rounded-4 border-0 w-100 bg-white">

            <h5 class="text-center mb-3 text-dark">Make a Payment</h5>

            <!-- Flash success message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Toggle buttons -->
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-outline-primary w-50 me-2 py-1" id="stkBtn">STK Push</button>
                <button class="btn btn-outline-secondary w-50 py-1" id="manualBtn">Paybill</button>
            </div>

            <!-- STK Push Form -->
            <form id="stkForm" action="{{ route('payment.stkpush') }}" method="POST">
                @csrf
                <input type="hidden" name="orderid" value="{{ $orderId }}">
                <div class="mb-2">
                    <label class="form-label text-dark mb-1">Amount</label>
                    <input type="number" value="{{ $amt }}" id="amount" name="amount" class="form-control form-control-sm" required readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label text-dark mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control form-control-sm" required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-100">Pay via STK</button>
            </form>

            <!-- Manual Paybill Section -->
            <div id="manualPay" style="display: none;">
                <p class="text-dark small mb-2">
                    To pay manually:
                    <ol class="text-dark small ps-3 mb-2">
                        <li>Go to <strong>M-Pesa</strong></li>
                        <li>Choose <strong>Lipa na M-Pesa</strong></li>
                        <li>Select <strong>Paybill</strong></li>
                        <li>Business Number: <strong>700201</strong></li>
                        <li>Account Number: <strong>6640005086</strong></li>
                        
                    </ol>
                </p>

                

                <!-- Contact Receiver -->
                <div class="mt-3 text-center small text-dark">
                    Need help? Contact <strong>Amos</strong>:<br>
                    <strong>+254 704 136678</strong> (Call/WhatsApp)
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const stkBtn = document.getElementById('stkBtn');
    const manualBtn = document.getElementById('manualBtn');
    const stkForm = document.getElementById('stkForm');
    const manualPay = document.getElementById('manualPay');

    stkBtn.onclick = () => {
        stkForm.style.display = 'block';
        manualPay.style.display = 'none';
        stkBtn.classList.add('btn-primary');
        stkBtn.classList.remove('btn-outline-primary');
        manualBtn.classList.remove('btn-secondary');
        manualBtn.classList.add('btn-outline-secondary');
    };

    manualBtn.onclick = () => {
        stkForm.style.display = 'none';
        manualPay.style.display = 'block';
        manualBtn.classList.add('btn-secondary');
        manualBtn.classList.remove('btn-outline-secondary');
        stkBtn.classList.remove('btn-primary');
        stkBtn.classList.add('btn-outline-primary');
    };

    

    // Fix focus issue on mobile
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', () => {
            window.scrollTo(0, input.getBoundingClientRect().top);
        });
    });
</script>
@endsection
