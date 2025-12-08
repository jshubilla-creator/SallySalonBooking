<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">🔔 Appointment Reminder</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 16px; color: #333333; margin: 0 0 20px;">Hi {{ $appointment->user->name }},</p>
                            
                            <p style="font-size: 16px; color: #333333; margin: 0 0 30px;">This is a friendly reminder about your upcoming appointment at <strong>Sally Salon</strong> tomorrow! ✨</p>
                            
                            <!-- Appointment Details Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 15px; font-size: 14px; color: #666;">
                                            <strong style="color: #333;">📅 Date:</strong><br>
                                            <span style="font-size: 16px; color: #667eea;">{{ $appointment->appointment_date->format('l, F d, Y') }}</span>
                                        </p>
                                        <p style="margin: 0 0 15px; font-size: 14px; color: #666;">
                                            <strong style="color: #333;">⏰ Time:</strong><br>
                                            <span style="font-size: 16px; color: #667eea;">{{ $appointment->start_time->format('g:i A') }}</span>
                                        </p>
                                        <p style="margin: 0 0 15px; font-size: 14px; color: #666;">
                                            <strong style="color: #333;">💇 Service:</strong><br>
                                            <span style="font-size: 16px; color: #333;">{{ $appointment->service->name }}</span>
                                        </p>
                                        <p style="margin: 0; font-size: 14px; color: #666;">
                                            <strong style="color: #333;">👤 Specialist:</strong><br>
                                            <span style="font-size: 16px; color: #333;">{{ $appointment->specialist->name }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 14px; color: #666; margin: 0 0 20px;">We look forward to seeing you! If you need to reschedule or cancel, please contact us as soon as possible. 📞</p>
                            
                            <p style="font-size: 14px; color: #333; margin: 0;">
                                Best regards,<br>
                                <strong>Sally Salon Team</strong> 💖
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; font-size: 12px; color: #999;">
                                © {{ date('Y') }} Sally Salon. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
