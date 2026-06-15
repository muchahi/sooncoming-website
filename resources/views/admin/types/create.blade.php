@extends('admin.layouts.main')

@section('title', 'Add New Type')

@section('content')
    <?php $types = \App\Models\ProductType::get(); ?>

    <div class="container">
        <div class="card">
            <div class="card-header">@yield('title')</div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.type.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Type Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Type</button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Product Types</div>
            <div class="card-body">


                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($types as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->slug }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="#" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No types found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
