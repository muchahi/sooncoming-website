 @extends('layouts.main')
 @section('title', 'content')
 @section('content')
     <!-- Chat list   -->
     <div class="row">
         <div class="col-12 px-0">
             <div class="list-group list-group-flush rounded-0 bg-none">
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">John Domnic <span class="float-end size-12 text-muted">2 min</span>
                             </p>
                             <p class="text-secondary"><i class="bi bi-check-all text-primary"></i> Thank you
                                 for your purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user2.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Alica Tirrantra<span class="float-end size-12 text-muted">4
                                     min</span></p>
                             <p class="text-secondary"><i class="bi bi-check"></i> Congratulations!</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user3.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Vijay Senapathi <span class="float-end size-12 text-muted">12
                                     min</span></p>
                             <p class="text-secondary"><i class="bi bi-check-all"></i> Thank you for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">John Domnic <span class="float-end size-12 text-muted">30 min</span>
                             </p>
                             <p class="text-secondary"><i class="bi bi-check-all text-primary"></i> Thank you
                                 for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user2.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Alica Tirrantra<span class="float-end size-12 text-muted">1
                                     hr</span></p>
                             <p class="text-secondary"><i class="bi bi-check"></i> Congratulations!</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user3.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Vijay Senapathi <span class="float-end size-12 text-muted">2
                                     hr</span></p>
                             <p class="text-secondary"><i class="bi bi-check-all"></i> Thank you for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">John Domnic <span class="float-end size-12 text-muted">2 min</span>
                             </p>
                             <p class="text-secondary"><i class="bi bi-check-all text-primary"></i> Thank you
                                 for your purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user2.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Alica Tirrantra<span class="float-end size-12 text-muted">4
                                     min</span></p>
                             <p class="text-secondary"><i class="bi bi-check"></i> Congratulations!</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user3.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Vijay Senapathi <span class="float-end size-12 text-muted">12
                                     min</span></p>
                             <p class="text-secondary"><i class="bi bi-check-all"></i> Thank you for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user1.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">John Domnic <span class="float-end size-12 text-muted">30 min</span>
                             </p>
                             <p class="text-secondary"><i class="bi bi-check-all text-primary"></i> Thank you
                                 for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user2.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Alica Tirrantra<span class="float-end size-12 text-muted">1
                                     hr</span></p>
                             <p class="text-secondary"><i class="bi bi-check"></i> Congratulations!</p>
                         </div>
                     </div>
                 </a>
                 <a href="chats.messages" class="list-group-item">
                     <div class="row">
                         <div class="col-auto">
                             <div class="avatar avatar-50 rounded-15 p-0 shadow-sm bg-white">
                                 <img src="{{ env('APP_ASSETS') }}/assets/img/user3.jpg" alt="" />
                             </div>
                         </div>
                         <div class="col align-self-center">
                             <p class="mb-0">Vijay Senapathi <span class="float-end size-12 text-muted">2
                                     hr</span></p>
                             <p class="text-secondary"><i class="bi bi-check-all"></i> Thank you for your
                                 purchase</p>
                         </div>
                     </div>
                 </a>
             </div>
         </div>
     </div>
 @endsection
