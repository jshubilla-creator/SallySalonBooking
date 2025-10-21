@component('mail::message')
# 💔 Appointment Cancelled

Hello **{{ $appointment->user->name }}**,

We regret to inform you that your appointment for  
**{{ $appointment->service->name }}**  
scheduled on **{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y - h:i A') }}**  
has been **cancelled** by our management team.

---

### 💬 Reason for Cancellation
> {{ $reason }}

---

### Appointment Summary
- **Service:** {{ $appointment->service->name }}
- **Specialist:** {{ $appointment->specialist->name }}
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
- **Time:** {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
- **Price:** ₱{{ number_format($appointment->total_price, 2) }}

---

We sincerely apologize for the inconvenience.  
If you’d like to **reschedule**, please contact us and we’ll gladly assist you.

@component('mail::button', ['url' => url('/customer/appointments/create')])
Book a New Appointment
@endcomponent

Thank you for your understanding,  
**Sally Salon Team**  
📞 +63 912 345 6789  
✉️ support@sallysalon.com
@endcomponent
