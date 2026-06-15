@extends('admin.layouts.main')

@section('content')
@if(auth()->user()->is_admin)
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-gradient"><i class="fas fa-percentage me-2"></i> Manage Offers - Discounts</h2>
    <input type="text" class="form-control w-25 shadow-sm border-0 rounded-pill px-4" placeholder="🔍 Search by Product ID or Category">
  </div>

  <div class="table-responsive">
    <table class="table table-hover table-bordered shadow rounded overflow-hidden">
      <thead class="table-dark text-center">
        <tr>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Discount (%)</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
     <tbody class="text-center align-middle">
  @foreach($offers as $offer)
  <tr id="product-row-{{ $offer->id }}">
    <td>{{ $offer->id }}</td>
    <td>{{ $offer->name }}</td>
    <td>{{ $offer->category->name ?? 'N/A' }}</td>

    <td>
      <span class="badge bg-warning text-dark" id="discount-cell-{{ $offer->id }}">
        {{ $offer->discount_percentage ?? '0' }}%
      </span>
    </td>

    <td>
      <span class="badge {{ 
        ($offer->status ?? '') == 'active' ? 'bg-success' : 
        (($offer->status ?? '') == 'expired' ? 'bg-secondary' : 'bg-info') }}">
        {{ ucfirst($offer->status ?? 'Active') }}
      </span>
    </td>

    <td>
      
      <button class="btn btn-sm btn-outline-primary me-1 edit-offer" 
        data-id="{{ $offer->id }}" 
        data-product-name="{{ $offer->name }}" 
        data-discount="{{ $offer->discount_percentage }}">
        <i class="fas fa-edit"></i>
      </button>

      <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" class="d-inline" id="deleteForm-{{ $offer->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-outline-danger delete-offer" data-id="{{ $offer->id }}">
          <i class="fas fa-trash-alt"></i>
        </button>
       
      </form>
    </td>
  </tr>
  @endforeach
</tbody>

    </table>
  </div>
</div>

<!-- Edit Offer Modal -->
<div class="modal fade" id="editOfferModal" tabindex="-1" aria-labelledby="editOfferLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header bg-gradient text-white">
        <h5 class="modal-title" id="editOfferLabel">
          <i class="fas fa-tag me-2"></i> Edit Offer Discount
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('admin.offers.update', $offer->id) }}" id="editOfferForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <input type="hidden" name="id" id="offer_id">

        <div class="mb-3">
            <label for="product_name" class="form-label fw-bold">Product Name</label>
            <input type="text" class="form-control border-0 shadow-sm" id="product_name" readonly>
        </div>

        <div class="mb-3">
            <label for="discount_percentage" class="form-label fw-bold">Discount Percentage</label>
            <input type="number" class="form-control border-0 shadow-sm" id="discount_percentage" name="discount_percentage" min="1" max="90" required>
        </div>
    </div>
     
    <div class="modal-footer bg-light rounded-bottom">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancel
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Save Changes
        </button>
    </div>
    
</form>

      
    </div>
  </div>
</div>

<!-- Modal Script -->
<!-- Add SweetAlert2 if not already included -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    // When user clicks Edit
    $('.edit-offer').on('click', function () {
      let id = $(this).data('id');
      let productName = $(this).data('product-name');
      let discount = $(this).data('discount');

      $('#offer_id').val(id);
      $('#product_name').val(productName);
      $('#discount_percentage').val(discount);

      $('#editOfferForm').data('id', id); // Store ID in form
      $('#editOfferModal').modal('show');
    });

    // AJAX form submission
    $('#editOfferForm').on('submit', function (e) {
      e.preventDefault();

      let id = $(this).data('id');
      let url = `/admin/offers/update-discount/${id}`;
      let formData = $(this).serialize();

      $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function (response) {
          if (response.success) {
            // Update discount cell in the table
            $(`#discount-cell-${id}`).text($('#discount_percentage').val() + '%');

            // Close modal
            $('#editOfferModal').modal('hide');

            // Show confirmation
            Swal.fire({
              icon: 'success',
              title: 'Discount Updated',
              text: response.message,
              timer: 2000,
              showConfirmButton: false
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while updating the discount.',
          });
        }
      });
    });
  });
  </script>
<script>
  $(document).ready(function () {
    // When user clicks Delete
    $('.delete-offer').on('click', function (e) {
      e.preventDefault(); // Prevent form from submitting normally

      let button = $(this);
      let id = button.data('id');
      let form = $('#deleteForm-' + id);  // Find the form for this specific offer

      // Ask for confirmation before deleting
      if (confirm('Are you sure you want to delete this discount?')) {
        // Perform AJAX request to delete the product
        $.ajax({
          url: form.attr('action'),  // Get the URL from the form action attribute
          type: 'POST',  // Send a POST request (because we're using a form)
          data: form.serialize(),  // Serialize the form data (including the CSRF token)
          success: function (response) {
            if (response.success) {
              // Remove the entire row from the table
              $('#product-row-' + id).fadeOut(500, function () {
                $(this).remove();  // Remove the row with this product's ID after fade out
              });

              // Show confirmation message
              Swal.fire({
                icon: 'success',
                title: 'Product Deleted',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
              });
            } else {
              alert('Could not delete the product.');
            }
          },
          error: function () {
            alert('Error occurred. Try again.');
          }
        });
      }
    });
  });
</script>




<!-- Styling -->
<style>
  .text-gradient {
    background: linear-gradient(to right, #6a11cb, #2575fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .bg-gradient {
    background: linear-gradient(to right, #007cf0, #00dfd8);
  }

  .table th, .table td {
    vertical-align: middle !important;
  }

  input.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
  }
</style>

<!-- Toast Success Message -->
@if(session('success'))
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

@else
<span class="text-muted">This page is only available to Admins</span>
@endif

@endsection
