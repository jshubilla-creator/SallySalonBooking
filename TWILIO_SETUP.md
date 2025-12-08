# Twilio SMS Integration Setup Guide

## 1. Create Twilio Account
1. Go to [https://www.twilio.com/](https://www.twilio.com/)
2. Sign up for a free account
3. Verify your phone number

## 2. Get Twilio Credentials
After creating your account, you'll need these credentials:

### Account SID and Auth Token
1. Go to Twilio Console Dashboard
2. Find your **Account SID** and **Auth Token**
3. Copy these values

### Phone Number
1. In Twilio Console, go to **Phone Numbers** > **Manage** > **Active numbers**
2. If you don't have a number, click **Buy a number**
3. Choose a number with SMS capabilities
4. Copy the phone number (format: +1234567890)

## 3. Configure Environment Variables
Add these to your `.env` file:

```env
# Twilio SMS Configuration
TWILIO_SID=your_account_sid_here
TWILIO_TOKEN=your_auth_token_here
TWILIO_FROM=+1234567890
```

**Replace with your actual values:**
- `TWILIO_SID`: Your Account SID from Twilio Console
- `TWILIO_TOKEN`: Your Auth Token from Twilio Console  
- `TWILIO_FROM`: Your Twilio phone number (must include country code)

## 4. Test SMS Functionality
1. Enable 2FA for a user account
2. Try logging in or changing password
3. Check if SMS is received

## 5. Troubleshooting

### Common Issues:
- **Invalid phone number**: Ensure phone numbers include country code (+1 for US)
- **Authentication error**: Double-check SID and Token
- **SMS not received**: Check Twilio logs in console

### Phone Number Format:
The system automatically formats phone numbers:
- `1234567890` → `+11234567890`
- `+1234567890` → `+1234567890` (no change)

### Twilio Trial Account Limitations:
- Can only send SMS to verified phone numbers
- Messages include "Sent from your Twilio trial account"
- Limited to $15.50 in credits

### Production Setup:
1. Upgrade to paid Twilio account
2. Verify your business for higher sending limits
3. Consider getting a short code for high volume

## 6. Cost Information
- **SMS Cost**: ~$0.0075 per message (US)
- **Phone Number**: ~$1/month
- **Free Trial**: $15.50 in credits

## 7. Security Best Practices
- Keep credentials in `.env` file (never commit to git)
- Use environment-specific credentials
- Monitor usage in Twilio Console
- Set up usage alerts

## 8. Alternative SMS Providers
If Twilio doesn't work for you, consider:
- **Vonage (Nexmo)**: Similar pricing and features
- **AWS SNS**: Good if you're using AWS
- **MessageBird**: European-focused
- **Plivo**: Cost-effective alternative

## 9. Fallback Behavior
If Twilio is not configured, the system will:
- Log SMS messages to Laravel logs
- Continue working without real SMS
- Show success messages to users