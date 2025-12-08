<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\PaymentTransaction;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPaymentIntent(Appointment $appointment, string $gateway = 'stripe')
    {
        $transaction = PaymentTransaction::create([
            'appointment_id' => $appointment->id,
            'transaction_id' => 'txn_' . Str::random(16),
            'payment_gateway' => $gateway,
            'amount' => $appointment->total_price,
            'currency' => 'PHP',
            'status' => 'pending',
        ]);

        // Simulate payment gateway integration
        $paymentUrl = $this->generatePaymentUrl($transaction, $gateway);
        
        return [
            'transaction' => $transaction,
            'payment_url' => $paymentUrl,
        ];
    }

    public function processPayment(PaymentTransaction $transaction, array $gatewayResponse)
    {
        $transaction->update([
            'status' => $gatewayResponse['status'] === 'success' ? 'completed' : 'failed',
            'gateway_response' => $gatewayResponse,
            'paid_at' => $gatewayResponse['status'] === 'success' ? now() : null,
        ]);

        if ($transaction->status === 'completed') {
            $transaction->appointment->update([
                'payment_status' => 'paid',
                'amount_paid' => $transaction->amount,
            ]);
        }

        return $transaction;
    }

    private function generatePaymentUrl(PaymentTransaction $transaction, string $gateway)
    {
        // Simulate different payment gateways
        $baseUrls = [
            'stripe' => 'https://checkout.stripe.com/pay/',
            'paypal' => 'https://www.paypal.com/checkoutnow?token=',
            'paymongo' => 'https://checkout.paymongo.com/s/',
        ];

        return $baseUrls[$gateway] . $transaction->transaction_id;
    }
}