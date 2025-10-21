<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManagerEmailController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            Mail::raw($request->message, function ($mail) use ($request) {
                $mail->to($request->email)
                     ->subject($request->subject)
                     ->from(config('mail.from.address'), config('mail.from.name', 'Salon Notification'));
            });

            return back()->with('success', '✅ Email sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Failed to send email: ' . $e->getMessage());
        }
    }
}
