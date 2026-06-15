 @extends('layouts.inside')
 @section('title', 'content')
 @section('content')
     <!-- Biling -->
     <div class="row mb-3">
         <div class="col align-self-center">
             <div class="card">
                 <div class="card-header bg-success text-white">
                     <div class="row">
                         <div class="col-auto">
                             <h6 class="mb-1">INVOICE</h6>
                             <p>Id: <b>#123456</b></p>
                         </div>
                         <div class="col text-end">
                             <h6 class="mb-1"><i class="bi bi-check-circle"></i> Paid</h6>
                             <p>GSTIN: <b>07124AEIPJ54</b></p>
                         </div>
                     </div>
                 </div>
                 <div class="card-body">
                     <div class="row">
                         <div class="col-12 col-md-6 mb-4">
                             <p class="mb-2">Sold By:</p>
                             <p class="text-secondary">oneuiux,
                                 <br> 1234 Main Apt., 4B Springfield,<br>ST 54321
                             </p>
                         </div>
                         <div class="col-12 col-md-6 mb-4">
                             <p class="mb-2">Billed To:</p>
                             <p class="text-secondary">Maxartkiller,
                                 <br> 1234 Main Apt., 4B Springfield,<br>ST 54321
                             </p>
                         </div>
                     </div>
                     <div class="row ">
                         <div class="col-12 col-md-6 mb-4">
                             <p class="mb-2">Payment Method:</p>
                             <p class="text-secondary ">Visa ending **** 4242
                                 <br>
                                 <a href="">maxartkiller@maxartkiller.com</a>
                             </p>
                         </div>
                         <div class="col-12 col-md-6">
                             <p class="mb-2">Order Date:</p>
                             <p class="text-secondary">Aug 7, 2021
                                 <br><span class="text-danger">Payment due Dec 1, 2021</span>
                             </p>
                         </div>
                     </div>

                 </div>

             </div>
         </div>
     </div>

     <!-- products -->
     <div class="row mb-2">
         <div class="col-12 col-md-6 ">
             <div class="card mb-3">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-auto">
                             <figure class="avatar avatar-60 rounded-15 border">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/categories4.png" alt=""
                                     class="w-100">
                             </figure>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0"><small class="text-secondary size-12">LAVA B500</small>
                             </p>
                             <h5>$ 265.00 <small class="text-secondary size-12">x 2 Qty</small></h5>
                         </div>
                         <div class="col-auto align-self-center ps-0">
                             <a href="track.html">Track <i class="bi bi-chevron-right"></i></a>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
         <div class="col-12 col-md-6 ">
             <div class="card mb-3">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-auto">
                             <figure class="avatar avatar-60 rounded-15 border">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/categories1.png" alt=""
                                     class="w-100">
                             </figure>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0"><small class="text-secondary size-12">Samsug TV
                                     SM5500</small></p>
                             <h5>$ 165.00</h5>
                         </div>
                         <div class="col-auto align-self-center ps-0">
                             <a href="track.html">Track <i class="bi bi-chevron-right"></i></a>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
         <div class="col-12 col-md-6 ">
             <div class="card mb-3">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-auto">
                             <figure class="avatar avatar-60 rounded-15 border">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/categories2.png" alt=""
                                     class="w-100">
                             </figure>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0"><small class="text-secondary size-12">Top Cloths</small>
                             </p>
                             <h5>$ 59.00</h5>
                         </div>
                         <div class="col-auto align-self-center ps-0">
                             <a href="track.html">Track <i class="bi bi-chevron-right"></i></a>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>

     <!-- pricing -->
     <div class="row mb-4">
         <div class="col align-self-center">
             <h6 class="title">Pricing</h6>
         </div>
     </div>

     <div class="row mb-3">
         <div class="col">
             <p>Shipping Cost</p>
         </div>
         <div class="col-auto">$ 10.00</div>
     </div>
     <div class="row mb-3">
         <div class="col">
             <p>Subtotal</p>
         </div>
         <div class="col-auto">$ 32.00</div>
     </div>

     <div class="row mb-3 text-success">
         <div class="col">
             <p>Discount</p>
         </div>
         <div class="col-auto">$ 89.00</div>
     </div>

     <div class="row fw-bold mb-4">
         <div class="mb-3 col-12">
             <div class="dashed-line"></div>
         </div>
         <div class="col">
             <p>Total</p>
         </div>
         <div class="col-auto">$ 400.00</div>
     </div>
     <div class="row mb-4">
         <div class="col-12 mb-4">
             <a href="#" class="btn btn-default shadow-sm btn-lg w-100 btn-rounded">Print</a>
         </div>
     </div>
 @endsection
