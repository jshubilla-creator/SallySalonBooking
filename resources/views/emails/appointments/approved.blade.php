<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #28a745; text-align: center;">🎉 Appointment Approved - You're All Set!</h1>
    
    <p>Hello <strong>{{ $appointment->user->name }}</strong>! 🌟</p>
    
    <p>Fantastic news! We're thrilled to confirm that your appointment for<br>
    <strong>{{ $appointment->service->name }}</strong><br>
    scheduled on <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y - h:i A') }}</strong><br>
    has been <strong>officially approved</strong> by our management team! 🎊</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #28a745;">📋 Appointment Summary</h3>
    <ul>
        <li><strong>Service:</strong> {{ $appointment->service->name }}</li>
        <li><strong>Specialist:</strong> {{ $appointment->specialist->name }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</li>
        <li><strong>Price:</strong> ₱{{ number_format($appointment->total_price, 2) }}</li>
    </ul>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <p>We're absolutely excited to pamper you! 💖<br>
    If you need to <strong>reschedule or make changes</strong>, please let us know <strong>at least 2 hours</strong> ahead of time.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/customer/appointments') }}" style="display: inline-block; padding: 12px 24px; background-color: #28a745; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">View Your Appointment</a>
    </div>
    
    <p style="text-align: center;">Thank you for choosing <strong>Sally Salon</strong> 💅<br>
    We'll make sure your experience is fabulous! ✨</p>
    
    <p style="text-align: center;">Warm regards,<br>
    <strong>Sally Salon Team</strong></p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>