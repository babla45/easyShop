<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'location' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'location' => $validated['location'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Send welcome email with detailed error logging
            try {
                \Log::info('Attempting to send welcome email to: ' . $user->email);
                Mail::to($user->email)->send(new WelcomeMail($user));
                
                if (Mail::failures()) {
                    \Log::error('Mail failed to send to: ' . $user->email);
                } else {
                    \Log::info('Welcome email sent successfully to: ' . $user->email);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send welcome email: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
            }

            return redirect('/login')
                ->with('success', 'Registration successful! Please check your email for welcome message.');
                
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }
}
