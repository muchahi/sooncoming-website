@extends('admin.layouts.main')

@section('title', 'Product List')

@section('content')
@if(auth()->user()->is_admin)
    <div class="container">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-header">@yield('title')</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td
                                            style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; max-width: 200px;">
                                            <div class="description-container">
                                                <span class="description-preview"
                                                    id="preview-{{ $product->id }}">{{ Str::limit($product->description, 50) }}</span>
                                                <span class="description-full" id="full-{{ $product->id }}"
                                                    style="display: none;">{{ $product->description }}</span>
                                                <button class="toggle-description badge badge-info"
                                                    data-id="{{ $product->id }}">Show
                                                    More</button>
                                            </div>
                                        </td>

                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                          
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to toggle description visibility
        function toggleDescription(id) {
            const preview = document.getElementById(`preview-${id}`); // Get the description preview by ID
            const fullDescription = document.getElementById(`full-${id}`); // Get the full description by ID

            if (fullDescription.style.display === "none" || fullDescription.style.display === "") {
                fullDescription.style.display = "inline"; // Show the full description
                preview.style.display = "none"; // Hide the preview
                document.querySelector(`button[data-id='${id}']`).textContent = "Show Less"; // Change button text
            } else {
                fullDescription.style.display = "none"; // Hide the full description
                preview.style.display = "inline"; // Show the preview
                document.querySelector(`button[data-id='${id}']`).textContent = "Show More"; // Change button text
            }
        }

        // Attach click event listeners to all toggle buttons
        document.querySelectorAll('.toggle-description').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id'); // Get the product ID
                toggleDescription(id); // Call the toggle function
            });
        });
    </script>

   @else
   <span class="text-muted">This page is only available to Admins</span>
   @endif

@endsection
