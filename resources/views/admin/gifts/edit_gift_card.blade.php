@extends('admin.layouts.main')

@section('title', 'Edit Gift Card')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="mb-4">Edit Gift Card</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('gift-card.update', $giftCard->image_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Current Image:</label><br>
                @if($giftCard->image)
                    <img src="{{ asset('assets/img/' . $giftCard->image) }}" alt="Gift Card" class="img-thumbnail" width="200">
                @else
                    <p class="text-muted">No image uploaded.</p>
                @endif
            </div>
             @if(auth()->user()->is_admin)
            <div class="mb-3">
                <label class="form-label">Upload New Image:</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Discount (%):</label>
                <input type="text" name="discount" value="{{ $giftCard->discount }}" class="form-control" placeholder="Enter discount">
                @error('discount')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Gift Card</button>
            @else
            <span class="text-muted">Restricted</span>
            @endif
        </form>
    </div>
</div>
<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
