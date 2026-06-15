@extends('admin.layouts.main')
@section('title', 'View Location')

@section('content')
 @if(auth()->user()->is_admin
    <h5>{{ $location->place }}</h5>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $location->place }}</h5>
            <p class="card-text">
                <strong>Type:</strong> {{ ucfirst($location->type) }}<br>
                <strong>Country:</strong> {{ $location->country ?? 'N/A' }}<br>
                <strong>City:</strong> {{ $location->city ?? 'N/A' }}<br>
                <strong>Postal Code:</strong> {{ $location->postal_code ?? 'N/A' }}
            </p>
            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Back to List</a>
            @else
            <span class="text-muted">Restricted</span>
            @endif
        </div>
    </div>
@endsection
