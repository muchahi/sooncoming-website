@extends('admin.layouts.main')

@section('title', 'Users List')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">@yield('title', 'Edit User')</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" required>
                </div>

                <div class="form-group">
                    <label for="is_admin">Role</label>
                    <select name="is_admin" id="is_admin" class="form-control" required>
                        <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                   @if(auth()->user()->is_admin)
                <button type="submit" class="btn btn-success">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                @else
                <span class="text-muted">Restricted</span>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection