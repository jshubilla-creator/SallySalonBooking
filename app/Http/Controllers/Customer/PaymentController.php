<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PaymentTransaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        
        return view('customer.payments.show', compact('appointment'));
    }

    public function create(Request $request, Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        
        $gateway = $request->get('gateway', 'stripe');
        $result = $this->paymentService->createPaymentIntent($appointment, $gateway);
        
        return response()->json([
            'success' => true,
            'payment_url' => $result['payment_url'],
            'transaction_id' => $result['transaction']->transaction_id,
        ]);
    }

    public function callback(Request $request, PaymentTransaction $transaction)
    {
        // Simulate payment gateway callback
        $gatewayResponse = [
            'status' => $request->get('status', 'success'),
            'gateway_transaction_id' => $request->get('txn_id', 'gw_' . uniqid()),
            'timestamp' => now()->toISOString(),
        ];

        $this->paymentService->processPayment($transaction, $gatewayResponse);

        $message = $transaction->status === 'completed' 
            ? 'Payment successful! Your appointment is confirmed.'
            : 'Payment failed. Please try again.';

        return redirect()->route('customer.appointments.show', $transaction->appointment)
            ->with($transaction->status === 'completed' ? 'success' : 'error', $message);
    }
}