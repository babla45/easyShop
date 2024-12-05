<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function sendSMS(Request $request)
    {
        $validatedData = $request->validate(
            [
                'phone' => 'required|regex:/^\+[1-9]\d{1,14}$/', // Validate E.164 format
                'message' => 'required|max:160', // Limit to 160 characters
            ],
            [
                'phone.required' => 'The phone number is required.',
                'phone.regex' => 'The phone number must be in E.164 format (e.g., +1234567890).',
                'message.required' => 'The message cannot be empty.',
                'message.max' => 'The message must not exceed 160 characters.',
            ]
        );

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        try {
            $client = new Client($sid, $token);

            $message = $client->messages->create(
                $validatedData['phone'],
                [
                    'from' => $twilioPhoneNumber,
                    'body' => $validatedData['message'],
                ]
            );

            if ($message->sid) {
                return back()->with('success', 'SMS sent successfully!');
            } else {
                return back()->with('error', 'Failed to send SMS. Try again later.');
            }
        } catch (\Twilio\Exceptions\RestException $e) {
            return back()->with('error', 'Twilio Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
