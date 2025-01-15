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
use Illuminate\Support\Facades\Mail;

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
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('index')->with('success', 'You have been logged out successfully');
})->name('logout')->middleware('auth');

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

// Test routes (remove in production)
Route::get('/test-mail', function () {
    $order = \App\Models\Order::first();
    \Mail::to('babla@gmail.com')->send(new \App\Mail\OrderConfirmation($order));
    return 'Test email sent!';
});

// Test email route (remove in production)
Route::get('/test-email', function () {
    try {
        $user = \App\Models\User::first();
        
        if (!$user) {
            return 'Error: No user found in database';
        }

        \Log::info('Attempting to send email to: ' . $user->email);
        
        Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));
        
        if (Mail::failures()) {
            return 'Error sending email. Check logs for details.';
        }
        
        return 'Email sent successfully to: ' . $user->email;
        
    } catch (\Exception $e) {
        \Log::error('Email error: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage() . ' (Check logs for more details)';
    }
});
