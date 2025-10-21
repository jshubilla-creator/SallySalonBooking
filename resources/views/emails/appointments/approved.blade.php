@component('mail::message')
# 🎉 Appointment Approved

Hello **{{ $appointment->user->name }}**,

We’re excited to let you know that your appointment for  
**{{ $appointment->service->name }}**  
scheduled on **{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y - h:i A') }}**  
has been **approved** by our management team.

---

### 📋 Appointment Summary
- **Service:** {{ $appointment->service->name }}
- **Specialist:** {{ $appointment->specialist->name }}
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
- **Time:** {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
- **Price:** ₱{{ number_format($appointment->total_price, 2) }}

---

We can’t wait to see you soon!  
If you need to **reschedule or make changes**, please let us know ahead of time.

@component('mail::button', ['url' => url('/customer/appointments')])
View Your Appointment
@endcomponent

Thank you for choosing **Sally Salon** 💅  
We’ll make sure your experience is fabulous! ✨  

Warm regards,  
**Sally Salon Team**  
📞 +63 912 345 6789  
✉️ support@sallysalon.com
@endcomponent
