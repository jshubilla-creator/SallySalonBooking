<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Booked Successfully</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #8B5CF6; text-align: center;">📅 Appointment Booked Successfully!</h1>
    
    <p>Hello <strong>{{ $appointment->user->name }}</strong>! 🌟</p>
    
    <p>Thank you for choosing <strong>Sally Salon</strong>! Your appointment has been successfully submitted and is currently <strong>pending confirmation</strong> from our amazing team.</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #8B5CF6;">💅 Your Appointment Details</h3>
    <ul>
        <li><strong>Service:</strong> {{ $appointment->service->name }}</li>
        <li><strong>Specialist:</strong> {{ $appointment->specialist->name }}</li>
        <li><strong>Date:</strong> {{ $appointment->appointment_date->format('F j, Y') }}</li>
        <li><strong>Time:</strong> {{ $appointment->start_time->format('g:i A') }}</li>
        <li><strong>Duration:</strong> {{ $appointment->service->duration_minutes }} minutes</li>
        <li><strong>Price:</strong> ₱{{ number_format($appointment->total_price, 2) }}</li>
        @if($appointment->tip_amount > 0)
        <li><strong>Tip:</strong> ₱{{ number_format($appointment->tip_amount, 2) }}</li>
        @endif
        <li><strong>Total:</strong> ₱{{ number_format($appointment->grand_total, 2) }}</li>
        <li><strong>Status:</strong> 🟡 {{ ucfirst($appointment->status) }}</li>
    </ul>
    
    @if($appointment->is_home_service)
    <p><strong>🏠 Home Service Address:</strong> {{ $appointment->home_address }}</p>
    @endif
    
    @if($appointment->notes)
    <h4>📝 Special Notes</h4>
    <blockquote style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #8B5CF6; margin: 20px 0;">
        {{ $appointment->notes }}
    </blockquote>
    @endif
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #8B5CF6;">What's Next? 🤔</h3>
    <p>✅ We'll review your appointment request<br>
    📧 You'll receive a confirmation email once approved<br>
    💫 Get ready to look absolutely stunning!</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/customer/appointments') }}" style="display: inline-block; padding: 12px 24px; background-color: #8B5CF6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">View My Appointments</a>
    </div>
    
    <p style="text-align: center;">We can't wait to pamper you! 💖<br>
    <strong>Sally Salon Team</strong> ✨</p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>