@extends('admin.layouts.main')

@section('title', 'Add New Location')

@section('content')
    <h5>Add New Location</h5>

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        @include('admin.locations._form')
    </form>
@endsection
