@extends('admin.layouts.main')

@section('title', 'Locations')

@section('content')

 @if(auth()->user()->is_admin)
    <h5>Locations</h5>
    <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Add New Location</a>

    <div class="row">
        @foreach ($locations as $location)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $location->place }}</h5>
                        <p class="card-text">
                            <strong>Type:</strong> {{ ucfirst($location->type) }}<br>
                            <strong>Country:</strong> {{ $location->country ?? 'N/A' }}<br>
                            <strong>City:</strong> {{ $location->city ?? 'N/A' }}<br>
                            <strong>Postal Code:</strong> {{ $location->postal_code ?? 'N/A' }}
                        </p>
                       
                        <a href="{{ route('locations.show', $location->id) }}" class="btn btn-secondary btn-sm">View</a>
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                           
                        </form>
                      
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <span class="text-muted">This page is only available to admins</span>
    @endif
@endsection
