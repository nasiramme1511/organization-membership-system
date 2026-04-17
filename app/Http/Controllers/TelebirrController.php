<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TelebirrController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'plan_id' => 'required|exists:membership_plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $member = User::findOrFail($request->member_id);

        // Generate simulated transaction reference
        $transactionRef = 'TB'.date('YmdHis').rand(1000, 9999);

        // Create pending payment record
        $payment = Payment::create([
            'user_id' => $member->id,
            'amount' => $request->amount,
            'method' => 'telebirr',
            'status' => 'pending',
            'transaction_ref' => $transactionRef,
        ]);

        Log::info("Telebirr Payment Initiated: {$transactionRef} for member {$member->email}, amount {$request->amount}");

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated successfully',
            'transaction_ref' => $transactionRef,
            'amount' => $request->amount,
            'member' => $member->email,
        ]);
    }

    public function handleCallback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_ref' => 'required',
            'status' => 'required|in:SUCCESS,FAILED',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid callback'], 400);
        }

        $payment = Payment::where('transaction_ref', $request->transaction_ref)->first();

        if (! $payment) {
            Log::error("Telebirr Callback: Payment not found - {$request->transaction_ref}");

            return response()->json(['error' => 'Payment not found'], 404);
        }

        $newStatus = $request->status === 'SUCCESS' ? 'confirmed' : 'failed';

        $payment->status = $newStatus;

        if ($newStatus === 'confirmed') {
            $payment->paid_at = now();
        }

        $payment->save();

        Log::info("Telebirr Callback: {$request->transaction_ref} -> {$newStatus}");

        return response()->json(['success' => true]);
    }

    // Simulate success for testing
    public function simulateSuccess($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        $payment->status = 'confirmed';
        $payment->paid_at = now();
        $payment->save();

        return redirect()->back()->with('status', 'Payment confirmed!');
    }
}
