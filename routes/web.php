<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// User Registration Routes
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register'])->name('register.user');

// User Login Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');


// twilio sms
use App\Http\Controllers\SMSController;
Route::get('/sms', function () {
    return view('sms'); // Display the form
});
Route::post('/sms/send', [SMSController::class, 'sendSMS'])->name('sms.send');
