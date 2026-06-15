@extends('layouts.inside')

@section('content')
<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center px-3" style="z-index: 1050; background-color: rgba(0,0,0,0.5);">
    <div class="bg-primary rounded-4 p-4 w-100" style="max-width: 480px;">
        <div class="card shadow-lg p-4 rounded-4 border-0 w-100 bg-white">
            <h4 class="text-center mb-4 text-dark">Make a Payment</h4>

           
            <!-- Manual Paybill Section -->
            <div id="manualPay" style="display: ;">
                <p class="text-dark">
                    To pay manually:
                    <ol class="text-dark">
                        <li>Go to <strong>M-Pesa</strong></li>
                        <li>Choose <strong>Lipa na M-Pesa</strong></li>
                        <li>Select <strong>Paybill</strong></li>
                        <li>Enter Business Number: <strong>123456</strong></li>
                        <li>Enter Account Number: <strong>YourNameOrOrderID</strong></li>
                        <li>Enter Amount</li>
                        <li>Complete Payment</li>
                    </ol>
                </p>
                <form action="{{ url('/confirm-manual-payment') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="manual_phone" class="form-label text-dark">Phone Number</label>
                        <input type="text" id="manual_phone" name="manual_phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reference" class="form-label text-dark">M-Pesa Reference Code</label>
                        <input type="text" id="reference" name="reference" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Confirm Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
