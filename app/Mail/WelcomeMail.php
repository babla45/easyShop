<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        try {
            return $this->subject('Welcome to EasyShop!')
                       ->view('emails.welcome');
        } catch (\Exception $e) {
            Log::error('Error building welcome email: ' . $e->getMessage());
            throw $e;
        }
    }
} 