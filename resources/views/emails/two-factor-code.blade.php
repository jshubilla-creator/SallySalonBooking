<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #8B5CF6; text-align: center;">🔐 Your Verification Code</h1>
    
    <p>Hello <strong>{{ $user->name }}</strong>! 👋</p>
    
    <p>We received a request to verify your account. Here's your secure verification code:</p>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <h2 style="font-size: 32px; font-weight: bold; color: #333; margin: 0;">{{ $code }}</h2>
        <p style="margin: 10px 0 0 0; color: #666;"><strong>Valid for 5 minutes</strong> ⏰</p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #8B5CF6;">🛡️ Security Tips</h3>
    <ul>
        <li><strong>Never share</strong> this code with anyone</li>
        <li>This code <strong>expires in 5 minutes</strong></li>
        <li>If you didn't request this, please contact us immediately</li>
    </ul>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/customer/dashboard') }}" style="display: inline-block; padding: 12px 24px; background-color: #8B5CF6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Go to Dashboard</a>
    </div>
    
    <p style="text-align: center;">Stay secure and beautiful! ✨<br>
    <strong>Sally Salon Team</strong> 💅</p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>