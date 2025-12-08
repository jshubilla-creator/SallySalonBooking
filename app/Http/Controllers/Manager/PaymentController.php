<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Appointment::with(['user', 'service', 'paymentTransactions'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('manager.payments.index', compact('payments'));
    }

    public function recordPayment(Request $request, $id)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->amount_paid = $request->amount_paid;

        // Auto mark as paid if amount covers total
        if ($appointment->amount_paid >= $appointment->total_price) {
            $appointment->payment_status = 'paid';
        }

        $appointment->save();

        return redirect()->route('manager.payments.index')
            ->with('success', 'Customer payment recorded successfully.');
    }
    public function update(Request $request, $id)
{
    $request->validate(['amount_paid' => 'required|numeric|min:0']);

    $payment = Appointment::findOrFail($id);
    $payment->amount_paid = $request->amount_paid;
    $payment->payment_status = $payment->amount_paid >= $payment->total_price ? 'paid' : 'pending';
    $payment->save();

    return redirect()->route('manager.payments.index')->with('success', 'Payment updated successfully.');
}

public function destroy($id)
{
    $payment = Appointment::findOrFail($id);
    $payment->amount_paid = null;
    $payment->payment_status = 'pending';
    $payment->save();

    return redirect()->route('manager.payments.index')->with('success', 'Payment record deleted.');
}

}
