<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\PDF;

class InvoiceController extends Controller
{
    public function generate($paymentId)
    {
        $payment = Payment::with(['user', 'user.plan'])->findOrFail($paymentId);

        $user = $payment->user;
        $organization = Organization::first();

        $data = [
            'payment' => $payment,
            'user' => $user,
            'organization' => $organization,
            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];

        $pdf = PDF::loadView('invoices.template', $data);

        return $pdf->download("invoice-{$payment->id}.pdf");
    }

    public function preview($paymentId)
    {
        $payment = Payment::with(['user'])->findOrFail($paymentId);

        $user = $payment->user;
        $organization = Organization::first();

        $data = [
            'payment' => $payment,
            'user' => $user,
            'organization' => $organization,
            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];

        return view('invoices.template', $data);
    }
}
