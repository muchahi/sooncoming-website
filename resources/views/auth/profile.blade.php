@extends('layouts.main')

@section('content')
<?php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $aboutImages = App\Models\AboutImage::all();
?>
<div class="main-container container py-4 px-2">

    <!-- Header Section -->
    <div class="rounded-4 shadow-sm p-4 text-center mb-4" style="background: linear-gradient(135deg, #3B82F6, #60A5FA); color: white; border-radius: 1.5rem;">
        <div class="mb-3">
            <figure class="avatar avatar-100 rounded-circle bg-white d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-person-circle fs-1 text-primary"></i>
            </figure>
        </div>
        <h1 class="mb-0 fw-bold" style="color: black;">SoonComming</h1>
        <p class="mb-3">{{ $user->email }}</p>

        <!-- Action Buttons -->
        <div class="row g-2 justify-content-center">
            <div class="col-4">
                <a href="https://chat.whatsapp.com/K9X8FbYIPIQETTCNOXbbvk" target="_blank" class="btn btn-light w-100 rounded-3 py-2">
                    <i class="bi bi-people-fill d-block"></i>
                    <small>Community</small>
                </a>
            </div>
            <div class="col-4">
                <a href="tel:+254704136678" class="btn btn-light w-100 rounded-3 py-2">
                    <i class="bi bi-telephone-fill d-block"></i>
                    <small>Call</small>
                </a>
            </div>
            <div class="col-4">
              <a href="https://www.google.com/maps?q=-1.284152,36.822407&z=20&hl=en" class="btn btn-light w-100 rounded-3 py-2">



                    <i class="bi bi-geo-alt-fill d-block"></i>
                    <small>Location</small>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Background -->
    <div class="p-3 rounded-4 shadow-sm mb-4" style="background: linear-gradient(135deg, #e0f2fe, #e0e7ff); border-radius: 1.5rem;">

        <!-- Welcome Message Section -->
        <div class="p-3 rounded-4 shadow-sm text-center mb-4" style="background: #dbeafe;">
            <p class="mb-0 text-dark">
                👋 <strong>Welcome to SoonComming!</strong><br>
                We're glad to have you here!  Feel free to explore and enjoy our community 
            </p>
        </div>

        <!-- About Us Section -->
        <div class="mb-3">
            <h6 class="fw-bold text-dark">ABOUT US</h6>
        </div>

        <!-- About Us Card Area -->
        <div class="p-3 rounded-4" style="background: linear-gradient(135deg, #c7d2fe, #e0e7ff); border-radius: 1rem;">
            <div class="row g-2 mb-2">
                @foreach($aboutImages->take(6) as $image)
                    <div class="col-4">
                        <div class="about-box rounded-3 overflow-hidden shadow-sm">
                            <center>
                                          <img src="{{ asset('public/assets/about/' . $image->filename) }}" class="img-fluid" alt="About Image">

                            </center>
                 
                        </div>
                    </div>
                @endforeach
                @for($i = $aboutImages->count(); $i < 6; $i++)
                    <div class="col-4">
                        <div class="about-box rounded-3 overflow-hidden shadow-sm bg-light d-flex justify-content-center align-items-center" style="height: 100px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>

    <!-- Hidden Location Map -->
   <!-- Hidden Location Map -->
<div class="d-none" id="locationMap">
    <iframe
        src="https://maps.google.com/maps?q=-1.2831404209136963%2C36.822837829589844&z=17&hl=en"
        width="100%"
        height="250"
        style="border:0; border-radius: 1rem;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>


<!-- Hover CSS -->
<style>
    .about-box {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .about-box:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 0 15px rgba(59, 130, 246, 0.3);
    }
</style>
@endsection
