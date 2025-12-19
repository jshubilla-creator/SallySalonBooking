<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        return view('manager.reminders.create', compact('user'));
    }

    public function sendManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $user = User::findOrFail($request->user_id);

        try {
            $htmlMessage = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>' . $request->subject . '</title>
            </head>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(135deg, #ffeef8, #f3e8ff, #e0f2fe);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #8B5CF6; font-size: 28px; margin: 0;">✨ Sally Salon ✨</h1>
                    <p style="color: #666; margin: 5px 0;">Where Beauty Meets Excellence</p>
                </div>
                
                <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 2px solid #f8f9fa;">
                    <div style="white-space: pre-line; font-size: 16px; line-height: 1.8;">' . nl2br(e($request->message)) . '</div>
                </div>
                
                <div style="text-align: center; margin-top: 30px; padding: 20px; background: rgba(255,255,255,0.8); border-radius: 10px;">
                    <p style="margin: 0; color: #8B5CF6; font-weight: bold;">💅 Sally Salon Team 💖</p>
                    <p style="margin: 5px 0; color: #666; font-size: 14px;">📞 09319309716 | ✉️ ptc.johnalexishubilla@gmail.com</p>
                </div>
            </body>
            </html>';
            
            Mail::send([], [], function ($message) use ($user, $request, $htmlMessage) {
                $message->to($user->email)
                        ->subject($request->subject)
                        ->html($htmlMessage);
            });
            
            return redirect()->back()->with('success', 'Email sent successfully to ' . $user->email);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}