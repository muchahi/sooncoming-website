@extends('admin.layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Upload About Us Images</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.upload.about') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(auth()->user()->is_admin)
        <div class="mb-3">
            <label for="images" class="form-label">Choose up to 6 images</label>
            <input type="file" name="image" id="images" class="form-control" required accept="image/*">
            <small class="text-muted">Max size: 2MB per image. Allowed: jpeg, png, jpg, gif.</small>
        </div>

        <button type="submit" class="btn btn-primary">Upload Images</button>
        @else
        <span class="text-muted">Restricted</span>
        @endif
    </form>

    <div class="row mt-4">
        @foreach(\App\Models\AboutImage::latest()->take(6)->get() as $image)
            <div class="col-md-2 col-4 mb-3">
                <div class="border rounded p-2 bg-light text-center">
                    <img src="{{ asset('public/assets/about/' . $image->filename) }}" class="img-fluid rounded" style="height: 100px; object-fit: cover;" alt="About Image">
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
