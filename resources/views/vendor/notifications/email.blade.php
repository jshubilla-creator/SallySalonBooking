<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $greeting ?? 'Sally Salon' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f8f9fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px; font-weight: bold;">💇‍♀️ Sally Salon</h1>
                            <p style="color: #ffffff; margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Your Beauty, Our Passion</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            {{-- Greeting --}}
                            @if (! empty($greeting))
                                <h2 style="color: #333333; margin: 0 0 20px; font-size: 24px;">{{ $greeting }} ✨</h2>
                            @else
                                @if ($level === 'error')
                                    <h2 style="color: #e74c3c; margin: 0 0 20px; font-size: 24px;">🚨 Whoops!</h2>
                                @else
                                    <h2 style="color: #333333; margin: 0 0 20px; font-size: 24px;">Hello Beautiful! 💖</h2>
                                @endif
                            @endif
                            
                            {{-- Intro Lines --}}
                            @foreach ($introLines as $line)
                                <p style="font-size: 16px; color: #555555; line-height: 1.6; margin: 0 0 16px;">{{ $line }}</p>
                            @endforeach
                            
                            {{-- Action Button --}}
                            @isset($actionText)
                                <div style="text-align: center; margin: 30px 0;">
                                    <a href="{{ $actionUrl }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 25px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: all 0.3s ease;">{{ $actionText }} 🔐</a>
                                </div>
                            @endisset
                            
                            {{-- Outro Lines --}}
                            @foreach ($outroLines as $line)
                                <p style="font-size: 16px; color: #555555; line-height: 1.6; margin: 0 0 16px;">{{ $line }}</p>
                            @endforeach
                            
                            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                                {{-- Salutation --}}
                                @if (! empty($salutation))
                                    <p style="font-size: 16px; color: #333333; margin: 0;">{{ $salutation }}</p>
                                @else
                                    <p style="font-size: 16px; color: #333333; margin: 0;">
                                        With love and beauty,<br>
                                        <strong style="color: #667eea;">💖 Sally Salon Team</strong>
                                    </p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    {{-- Subcopy --}}
                    @isset($actionText)
                        <tr>
                            <td style="background-color: #f8f9fa; padding: 20px 30px; border-top: 1px solid #e9ecef;">
                                <p style="font-size: 12px; color: #999999; margin: 0; line-height: 1.5;">
                                    If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser:
                                </p>
                                <p style="font-size: 12px; color: #667eea; margin: 10px 0 0; word-break: break-all;">
                                    {{ $displayableActionUrl }}
                                </p>
                            </td>
                        </tr>
                    @endisset
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #333333; padding: 20px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #ffffff; opacity: 0.8;">
                                © {{ date('Y') }} Sally Salon. All rights reserved. 💅
                            </p>
                            <p style="margin: 5px 0 0; font-size: 12px; color: #ffffff; opacity: 0.6;">
                                Professional Salon Booking Management System
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
