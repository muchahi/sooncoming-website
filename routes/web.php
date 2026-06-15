<?php
use App\Http\Controllers\WishlistController;
use App\Events\MyEvent;
use App\Http\Controllers\AppLocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SignalingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\WebRTCController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\OfferController;

// Define the route that will call the showProducts method
Route::get('/products', [ProductController::class, 'showProducts'])->name('products.user'); //

Route::get('/live-stream', [StreamController::class, 'stream'])->name('stream');
Route::get('/stream/{filename}', [StreamController::class, 'stream']);
Route::post('/upload', [StreamController::class, 'upload']);
Route::post('/signal', [WebRTCController::class, 'signal']);
Route::get('/signaling', [SignalingController::class, 'index']);
Route::get('/video/host', function () {
    return view('video.host');
});


Route::get('video/viewer', function () {
    return view(view: 'video.viewer');
});

Route::get('/trigger-event', function () {
    event(new MyEvent('Hello, world!'));
    return 'Event triggered!';
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Dark Mode

Route::post('/toggle-darkmode', function () {
    session(['dark_mode' => !session('dark_mode')]);
    return redirect()->back();
})->name('toggle.darkmode');




// payment routes


// Notification Routes
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

// Route for chat page
// Route::get('/chat', [ChatController::class, 'chat'])->name('chat');

// Route for about us page
Route::get('/about-us', [ChatController::class, 'chat'])->name('about-us');






// Route for messages page
Route::get('/chat/messages', [ChatController::class, 'messages'])->name('chat.messages');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// User Routes
Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/logout', function(){ 
    Auth::logout();
    return redirect('/');
})->name('custom.logout');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/admin/gift-card/{id}/edit', [AdminController::class, 'editGiftCard'])->name('gift-card.edit');
Route::post('/admin/gift-card/{id}', [AdminController::class, 'updateGiftCard'])->name('gift-card.update');
// Product Routes
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/admin/giftcard/upload', [ProductController::class, 'upload'])->name('admin.giftcard.upload');

// Cart Routes'products.index'
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add'); 
Route::post('/cart/update', [CartController::class, 'addToCartById'])->name('cart.update'); 
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');



// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::post('/wishlist/add/{product}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::post('/wishlist/add-to-cart/{product}', [WishlistController::class, 'addToCartFromWishlist'])->name('wishlist.addToCart');


// Order Routes

Route::get('/address', [OrderController::class, 'address'])->name('address');
Route::get('/address/{id}', [OrderController::class, 'editAddress'])->name('edit-address');
Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
Route::get('/payment', [OrderController::class, 'payment'])->name('payment');
Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
Route::get('track/{id}', [OrderController::class, 'track'])->name('tracking.show');
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::get('/user/orders', [OrderController::class, 'userOrders'])->name('orders.user');


Route::delete('/order/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');


// order track
Route::get('/orders/track/{id}', [OrderController::class, 'track'])->name('orders.track');
//  order summary 
Route::get('/orders/summary/{id}',[OrderController::class, 'showOrderSummary'])
         ->name('orders.summary');



Route::post('/addaddress', [ShippingAddressController::class, 'addAddress'])->name('addresses.add');
Route::get('/addaddress', [ShippingAddressController::class, 'index'])->name('addresses.index');
Route::get('/address/{id}/edit', [ShippingAddressController::class, 'editAddress'])->name('addresses.edit');
Route::post('/address/{id}/update', [ShippingAddressController::class, 'updateAddress'])->name('addresses.update');
Route::get('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

Route::post('/payment/check/{order_id}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');
Route::get('payment/check/{order_id}', [PaymentController::class, 'checkPayment'])->name('payment.check');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::post('/payment/stkpush', [PaymentController::class, 'sendMobilePrompt'])->name('payment.stkpush');


// Admin Routes

Route::middleware(['auth'])->group(function () {
    Route::prefix('merchant')->group(function () {
        Route::get('onboard', [MerchantController::class, 'onboard']);
        Route::post('login', [MerchantController::class, 'login']);
        Route::get('home', [MerchantController::class, 'dashboard']);

        Route::resource('products', ProductController::class);
        Route::resource('categories', ProductCategoryController::class);
        Route::resource('types', ProductTypeController::class);
    });
    
    

    Route::prefix('admin')->group(function () {
       
       // Routes for the "Offers" section
       
        Route::get('/offers/discounts', [OfferController::class, 'discounts'])->name('admin.offers.discounts');
        Route::get('/offers/gifts', [OfferController::class, 'gifts'])->name('admin.offers.gifts');
       Route::delete('/offers/{id}', [OfferController::class, 'destroy'])->name('admin.offers.destroy');
      Route::put('/offers/update-discount/{id}', [OfferController::class, 'updateDiscount'])->name('admin.offers.update');

    
        // Orders Routes
        Route::get('/orders/index', [AdminController::class, 'liveOrders'])->name('admin.orders.liveorders');
        
        //  order history
        Route::get('/orders/history', [AdminController::class, 'orderHistory'])->name('admin.orders.history');

         // Handle Order Actions (Cancel Order, Cancel Product, Send Message)
          Route::post('/orders/{order}/action', [AdminController::class, 'handleAction'])->name('orders.action');
            // messages
        Route::post('/orders/{order}/send-message', [AdminController::class, 'sendMessageToCustomer'])->name('orders.send.message');
        Route::get('admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::put('admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::get('admin/users', [AdminController::class, 'confirmIndex'])->name('admin.users.index');

        // Route for sending a message to an order
        Route::post('admin/orders/{order}/message', [AdminController::class, 'sendMessage'])->name('admin.orders.message');
        // Route for processing a refund
        Route::post('admin/orders/{order}/refund', [AdminController::class, 'processRefund'])->name('admin.orders.refund');
         Route::resource('pickups', PickupController::class);
        Route::get('/dashboard', [AdminController::class, 'home'])->name('admin.dashboard');
        Route::get('merchants', [AdminController::class, 'manageMerchants'])->name('admin.merchants');
        Route::get('users', [AdminController::class, 'listAllUsers'])->name('admin.users');
      
        // AboutImages
        Route::get('/upload-about-images', [AdminController::class, 'showAboutUploadForm'])->name('admin.upload.about.form');

        Route::post('/upload-about-images', [AdminController::class, 'uploadAboutImages'])->name('admin.upload.about');


      
        Route::get('merchants/{id}', [AdminController::class, 'manageMerchants'])->name('admin.merchants.edit');
        Route::post('merchants/{id}', [AdminController::class, 'manageMerchants'])->name('admin.merchants.destroy');
        Route::get('merchant/onboard', [MerchantController::class, 'index'])->name('admin.merchant.add');
        Route::post('merchant/onboard', [MerchantController::class, 'onboard'])->name('admin.merchant.onboard');
        Route::post('suspend-merchant/{id}', [AdminController::class, 'suspendMerchant']);

        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('categories', ProductCategoryController::class)->names('admin.category');

        Route::get('product/add', [ManageProductController::class, 'create'])->name('admin.product.add');
        Route::post('product/store', [ManageProductController::class, 'create'])->name('admin.product.store');
        Route::get('product/category', [ManageProductController::class, 'createCategory'])->name('admin.product.category');
        Route::get('product/type', [ManageProductController::class, 'createType'])->name('admin.type');

        Route::post('gallery/upload', [ProductController::class, 'uploadImages'])->name('admin.gallery.upload');
        Route::post('product/store', [ProductController::class, 'storeProductWithImages'])->name('admin.product.store');

        Route::get('product/all', [ProductController::class, 'AdminIndex'])->name('admin.products.index');
        Route::get('product/{id}/edit', [ProductController::class, 'AdminEdit'])->name('admin.products.edit');
        Route::post('product/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('product/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::resource('locations', AppLocationController::class);
        
           
         

        
  });    
});
