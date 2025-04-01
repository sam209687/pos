<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\PaymentMethod;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use PDF;

class PaymentController extends Controller
{
    public function validatePayment(PaymentRequest $request)
    {
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        
        // Validate payment amount
        if ($request->amount_paid < $request->total_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient payment amount'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'change_amount' => $request->amount_paid - $request->total_amount
        ]);
    }

    public function generateReceipt(Sale $sale)
    {
        $sale->load(['user', 'paymentMethod', 'items.product']);
        
        // Generate QR code URL
        $qrCodeUrl = route('qrcode.receipt', $sale);
        
        $pdf = PDF::loadView('receipts.sale', compact('sale', 'qrCodeUrl'));
        
        return $pdf->stream('receipt-' . $sale->id . '.pdf');
    }

    public function getPaymentMethods()
    {
        $methods = PaymentMethod::where('status', true)->get();
        return response()->json($methods);
    }
}
