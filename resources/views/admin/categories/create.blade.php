@extends('admin.layouts.main')



@section('title', 'Add New Category')

@section('content')
 
  

 
    <?php $categories = \App\Models\ProductCategory::all(); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">@yield('title')</div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
               
                <form method="POST" action="{{ route('admin.category.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="revenue" class="form-label">Percentage Revenue</label>
                        <input type="number" class="form-control form-control-sm" id="revenue" name="revenue" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Category</button>
                   
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Categories Available</div>
            <div class="card-body">


                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Profits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->revenue }}</td>
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
                                <td colspan="4" class="text-center">No categories found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
@endsection
