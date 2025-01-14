<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\OrderTrackingController;

// Public routes
Route::middleware([\App\Http\Middleware\PreventAdminAccess::class])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    // Authentication routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register'])->name('register.user');
});

// Add this route outside of any middleware group since it needs to be accessible by all users
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected user routes (not for admins)
Route::middleware(['auth', \App\Http\Middleware\PreventAdminAccess::class])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/{cartItem}/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Order Routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'place'])->name('orders.place');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
});

// Product Management Routes (for admin only)
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Admin Routes
Route::prefix('admin')
    ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])
            ->name('admin.loginForm')
            ->withoutMiddleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
        
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])
            ->name('admin.login')
            ->withoutMiddleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
        
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
        
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)
            ->names('admin.products');
        
        Route::get('/orders/track', [App\Http\Controllers\Admin\OrderTrackingController::class, 'index'])
            ->name('admin.orders.track');
    });

// Move these routes inside the admin group above
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('products.destroy');

// Public product routes
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Add this route temporarily for testing
Route::get('/test-mail', function () {
    $order = \App\Models\Order::first();
    
    \Mail::to('your-email@example.com')->send(new \App\Mail\OrderConfirmation($order));
    
    return 'Test email sent!';
});

// Add this route temporarily (REMOVE IN PRODUCTION!)
Route::get('/make-admin', function() {
    $user = \App\Models\User::where('email', 'your@email.com')->first();
    if ($user) {
        $user->update(['is_admin' => true]);
        return "User {$user->name} is now an admin!";
    }
    return "User not found!";
});

// Add this temporary route at the end of the file
Route::get('/make-admin/{email}', function($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        $user->update(['is_admin' => true]);
        return "User {$user->name} is now an admin!";
    }
    return "User not found!";
});

// Add this temporarily and remove after testing
Route::get('/check-admin', function() {
    if (auth()->check()) {
        dd([
            'user_id' => auth()->id(),
            'is_admin' => auth()->user()->is_admin,
            'user_data' => auth()->user()->toArray()
        ]);
    }
    return 'Not logged in';
});

// Add this temporarily (REMOVE IN PRODUCTION!)
Route::get('/make-me-admin', function() {
    if (auth()->check()) {
        $user = auth()->user();
        $user->is_admin = true;
        $user->save();
        return "You are now an admin! Your admin status is: " . ($user->is_admin ? 'true' : 'false');
    }
    return "Please login first";
});

// Add this temporary route (REMOVE IN PRODUCTION!)
Route::get('/setup-admin', function() {
    $user = \App\Models\User::where('email', 'admin@gmail.com')->first();
    if ($user) {
        $user->is_admin = true;
        $user->save();
        return "Admin user setup complete! Admin status is: " . ($user->is_admin ? 'true' : 'false');
    }
    return "Admin user not found!";
});

// Admin Authentication Routes
Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.loginForm');
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');