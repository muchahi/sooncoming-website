@extends('admin.layouts.main')
@section('title', 'List All Merchants')
@section('content')
 
    <div class="container">
        <h4 class="mb-4">Merchants List</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Business Name</th>
                        <th>Location</th>
                        <th>Payment Methods</th>
                        <th>Drop Zone</th>
                        <th>Category</th>
                        <th>Unique Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($merchants as $key => $merchant)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $merchant->business_name }}</td>
                            <td>{{ $merchant->location }}</td>
                            <td>{{ implode(', ', json_decode($merchant->payment_methods)) }}</td>
                            <td>{{ $merchant->drop_zone }}</td>
                            <td>{{ $merchant->business_category }}</td>
                            <td><a href="{{ url($merchant->shop_unique_link) }}"
                                    target="_blank">{{ $merchant->shop_unique_link }}</a></td>
                            <td>
                                <!-- Action buttons (Edit, Delete) -->
                                <a href="{{ route('admin.merchants.edit', $merchant->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.merchants.destroy', $merchant->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  
   
@endsection
