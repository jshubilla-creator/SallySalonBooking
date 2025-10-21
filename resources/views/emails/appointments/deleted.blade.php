@component('mail::message')
# 🗑️ Appointment Deleted

Hello **{{ $appointment->user->name }}**,

We’d like to inform you that your appointment for  
**{{ $appointment->service->name }}**  
on **{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y - h:i A') }}**  
has been **deleted** from our system.

---

### 💬 Reason for Deletion
> {{ $reason }}

---

### Appointment Details
- **Service:** {{ $appointment->service->name }}
- **Specialist:** {{ $appointment->specialist->name }}
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
- **Time:** {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
- **Price:** ₱{{ number_format($appointment->total_price, 2) }}

---

If this was a mistake or you’d like to rebook, feel free to set a new appointment below.

@component('mail::button', ['url' => url('/customer/appointments/create')])
Book Again
@endcomponent

Thank you for your understanding,  
**Sally Salon Team**  
📞 +63 912 345 6789  
✉️ support@sallysalon.com
@endcomponent
