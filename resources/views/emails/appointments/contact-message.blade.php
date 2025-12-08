<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #007bff; text-align: center;">📬 New Contact Message Received</h1>
    
    <p>Hello <strong>Sally Salon Team</strong>! 👋</p>
    
    <p>You've received a new message through your contact form. Here are the details:</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #007bff;">👤 Customer Information</h3>
    <ul>
        <li><strong>Name:</strong> {{ $data['name'] }}</li>
        <li><strong>Email:</strong> {{ $data['email'] }}</li>
        <li><strong>Phone:</strong> {{ $data['phone'] ?? 'Not provided' }}</li>
    </ul>
    
    <h3 style="color: #007bff;">📋 Message Details</h3>
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #007bff;">
        <p style="margin: 0; color: #333; font-weight: bold;">Message:</p>
        <p style="margin: 10px 0 0 0; color: #555;">{{ $data['message'] }}</p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h3 style="color: #007bff;">🚀 Quick Actions</h3>
    <p>Please respond to this customer as soon as possible to maintain our excellent service standards!</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="mailto:{{ $data['email'] }}" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Reply to Customer</a>
    </div>
    
    <p style="text-align: center;"><strong>Sally Salon Management System</strong> 💼</p>
    
    <p style="text-align: center; color: #666; font-size: 14px;">
        📞 {{ config('app.salon_phone_number', '+63 912 345 6789') }}<br>
        ✉️ {{ config('mail.from.address') }}
    </p>
</body>
</html>