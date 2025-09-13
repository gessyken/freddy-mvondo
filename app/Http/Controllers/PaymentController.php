<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the payment form.
     */
    public function create(CivilAct $civilAct)
    {
        $this->authorize('view', $civilAct);
        
        if ($civilAct->status !== 'pending_payment') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande n\'est pas en attente de paiement.');
        }

        return view('payments.create', compact('civilAct'));
    }

    /**
     * Process the payment.
     */
    public function store(Request $request, CivilAct $civilAct)
    {
        $this->authorize('view', $civilAct);
        
        if ($civilAct->status !== 'pending_payment') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande n\'est pas en attente de paiement.');
        }

        $request->validate([
            'method' => 'required|in:mobile_money,bank_transfer,cash',
            'phone' => 'required_if:method,mobile_money|string',
            'account_number' => 'required_if:method,bank_transfer|string',
        ]);

        // Create payment record
        $payment = $civilAct->payments()->create([
            'amount' => $civilAct->amount,
            'method' => $request->method,
            'status' => 'pending',
            'transaction_id' => Str::uuid(),
            'payment_reference' => $this->generatePaymentReference($request->method),
        ]);

        // Simulate payment processing
        $this->processPayment($payment, $request);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Paiement initié avec succès.');
    }

    /**
     * Show payment details.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment->civilAct);
        
        return view('payments.show', compact('payment'));
    }

    /**
     * Handle payment callback (for webhooks).
     */
    public function callback(Request $request, Payment $payment)
    {
        // This would be called by the payment gateway
        $status = $request->input('status');
        $transactionId = $request->input('transaction_id');
        
        if ($status === 'success') {
            $payment->update([
                'status' => 'success',
                'transaction_id' => $transactionId,
                'processed_at' => now(),
                'gateway_response' => $request->all(),
            ]);

            // Update civil act status
            $payment->civilAct->update([
                'status' => 'under_review',
                'payment_status' => 'paid',
            ]);

            // Send notification
            $this->sendPaymentNotification($payment, 'success');
        } else {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $request->input('reason', 'Paiement échoué'),
                'gateway_response' => $request->all(),
            ]);

            $this->sendPaymentNotification($payment, 'failed');
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Simulate payment processing (for demo purposes).
     */
    private function processPayment(Payment $payment, Request $request)
    {
        // In a real application, this would integrate with payment gateways
        // For demo purposes, we'll simulate a successful payment after 5 seconds
        
        // Simulate payment processing delay
        sleep(2);
        
        // Simulate 90% success rate
        if (rand(1, 10) <= 9) {
            $payment->update([
                'status' => 'success',
                'processed_at' => now(),
                'gateway_response' => [
                    'method' => $payment->method,
                    'simulated' => true,
                ],
            ]);

            // Update civil act status
            $payment->civilAct->update([
                'status' => 'under_review',
                'payment_status' => 'paid',
            ]);

            $this->sendPaymentNotification($payment, 'success');
        } else {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'Simulation d\'échec de paiement',
                'gateway_response' => [
                    'method' => $payment->method,
                    'simulated' => true,
                ],
            ]);

            $this->sendPaymentNotification($payment, 'failed');
        }
    }

    /**
     * Generate payment reference based on method.
     */
    private function generatePaymentReference(string $method): string
    {
        $prefix = match($method) {
            'mobile_money' => 'MM',
            'bank_transfer' => 'BT',
            'cash' => 'CS',
            default => 'PAY'
        };

        return $prefix . '-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Send payment notification.
     */
    private function sendPaymentNotification(Payment $payment, string $status)
    {
        // In a real application, this would send SMS/email notifications
        // For now, we'll just log it
        \Log::info("Payment {$status} for civil act {$payment->civilAct->reference_number}", [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'method' => $payment->method,
        ]);
    }
}