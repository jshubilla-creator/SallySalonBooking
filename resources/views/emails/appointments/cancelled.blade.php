<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Cancelled</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #dc3545; text-align: center;">💔 Appointment Cancelled - We're Sorry!</h1>
    
    <p>Hello <strong>{{ $appointment->user->name }}</strong>! 😔</p>
    
    <p>We sincerely regret to inform you that your appointment for<br>
    <strong>{{ $appointment->service->name }}</strong><br>
    scheduled on <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y - h:i A') }}</strong><br>
    has been <strong>cancelled</strong> by our management team.</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #dc3545;">💬 Reason for Cancellation</h3>
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc3545;">
        <p style="margin: 0; color: #333; font-style: italic;">{{ $reason }}</p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #dc3545;">📋 Cancelled Appointment Details</h3>
    <ul>
        <li><strong>Service:</strong> {{ $appointment->service->name }}</li>
        <li><strong>Specialist:</strong> {{ $appointment->specialist->name }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</li>
        <li><strong>Price:</strong> ₱{{ number_format($appointment->total_price, 2) }}</li>
    </ul>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <p>We sincerely apologize for any inconvenience this may cause! 🙏<br>
    We'd love to make it up to you - please <strong>reschedule</strong> at your convenience and we'll ensure you receive our premium service! ✨</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/customer/appointments/create') }}" style="display: inline-block; padding: 12px 24px; background-color: #28a745; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Book a New Appointment</a>
    </div>
    
    <p style="text-align: center;">Thank you for your understanding and patience! 💖<br>
    <strong>Sally Salon Team</strong></p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>