<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #17a2b8; text-align: center;">⏰ Appointment Reminder</h1>
    
    <p>Hello <strong>{{ $appointment->user->name }}</strong>! 🌸</p>
    
    <p>This is a friendly reminder about your upcoming appointment at <strong>Sally Salon</strong>. We're excited to see you soon!</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #17a2b8;">💅 Appointment Details</h3>
    <ul>
        <li><strong>Service:</strong> {{ $appointment->service->name }}</li>
        <li><strong>Specialist:</strong> {{ $appointment->specialist->name }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</li>
        <li><strong>Duration:</strong> {{ $appointment->service->duration_minutes }} minutes</li>
        <li><strong>Total:</strong> ₱{{ number_format($appointment->total_price, 2) }}</li>
    </ul>
    
    @if($appointment->is_home_service)
    <p><strong>🏠 Service Location:</strong> Home Service at {{ $appointment->home_address }}</p>
    @else
    <p><strong>📍 Location:</strong> Sally Salon</p>
    @endif
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #17a2b8;">📋 Before Your Appointment</h3>
    <p>✨ <strong>Arrive 10 minutes early</strong> for check-in<br>
    💧 <strong>Stay hydrated</strong> and get a good night's sleep<br>
    📱 <strong>Bring your phone</strong> for any last-minute updates<br>
    💳 <strong>Payment ready</strong> - we accept cash and cards</p>
    
    <h3 style="color: #17a2b8;">🔄 Need to Reschedule?</h3>
    <p>If you need to make any changes, please contact us <strong>at least 2 hours</strong> before your appointment time.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/customer/appointments') }}" style="display: inline-block; padding: 12px 24px; background-color: #17a2b8; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">View Appointment Details</a>
    </div>
    
    <p style="text-align: center;">Can't wait to make you look fabulous! 💖<br>
    <strong>Sally Salon Team</strong> ✨</p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>