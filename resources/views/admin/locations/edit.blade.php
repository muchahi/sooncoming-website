@extends('admin.layouts.main')

@section('title', 'Edit Location')

@section('content')
  @if(auth()->user()->is_admin)
    <h5>Edit Location</h5>

    <form action="{{ route('locations.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.locations._form')
    </form>
    @else
    <span class="text-muted">Restricted</span>
    @endif
@endsection
