@extends('admin.layouts.main')

@section('title', 'Create A New Product')

@section('content')

    @php
        $locations = DB::table('locations')->get();
    @endphp
    <div class="container">
        <div class="card">
            <div class="card-header">@yield('title')</div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Product Form -->
                 @if(auth()->user()->is_admin)
                <form method="POST" action="{{ route('admin.product.store') }}" id="productForm" enctype="multipart/form-data">
                    @csrf
                   

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('name') }}"
                            id="name" name="name" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Product Description</label>
                        <textarea class="form-control form-control-sm" id="description" value="{{ old('description') }}" name="description"
                            rows="3" required></textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control form-control-sm" value="{{ old('price') }}"
                            id="price" name="price" required>
                    </div>

                    <!-- Stock -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control form-control-sm" value="{{ old('stock') }}"
                            id="stock" name="stock" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type_id" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Location</label>
                        <select class="form-select" id="type" name="location_id" required>
                            @foreach ($locations as $l)
                                <option value="{{ $l->id }}">{{ $l->place }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Hidden input to store image names -->
                    <input type="hidden" name="image_names" id="imageNames">

                    <!-- Submit Button for Product Form (outside the form tag) -->
                </form>

                <!-- Image Upload Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Drop Multiple Images</h4>
                    </div>
                    <div class="card-body">
                        <label>Drag and Drop Multiple Images (JPG, JPEG, PNG, .webp)</label>
                        <form action="{{ route('admin.gallery.upload') }}" method="POST" class="dropzone"
                            id="myDragAndDropUploader">
                            @csrf
                        </form>

                        <!-- Status message -->
                        <h5 id="message"></h5>
                    </div>
                </div>

                <!-- Submit Button (outside both forms) -->
                <button id="submitAll" class="btn btn-primary">Submit Product and Images</button>
                @else
                <span class="text-muted">Restricted</span>
                @endif

            </div>
        </div>
    </div>

    <script>
        var uploadedImages = []; // Array to hold uploaded image names

        // Dropzone Configuration
        Dropzone.options.myDragAndDropUploader = {
            paramName: "file[]", // Use array syntax for multiple files
            maxFilesize: 12, // Max file size in MB
            maxFiles: 5, // Allow a maximum of 5 files
            acceptedFiles: ".jpeg,.jpg,.png,.webp", // Allowed file types
            addRemoveLinks: false,
            timeout: 60000,
            dictDefaultMessage: "Drop your files here or click to upload",

            // When a file is successfully uploaded
            success: function(file, response) {
                $('#message').text('Images uploaded successfully!');
                uploadedImages.push(response.images); // Push the array of image names from the response
                console.log(response); // Log the array to check the file names
            },

            error: function(file, response) {
                $('#message').text('Something went wrong: ' + response);
            }
        };

        // When the external submit button is clicked
        document.getElementById('submitAll').addEventListener('click', function(e) {
            e.preventDefault();

            // Attach the uploaded image names to the hidden input field in the product form
            document.getElementById('imageNames').value = uploadedImages.join(',');

            // Submit the product form
            document.getElementById('productForm').submit();
        });
    </script>
@endsection
