<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function generateReceiptQR(Sale $sale)
    {
        $receiptUrl = route('receipts.view', ['sale' => $sale->id, 'token' => $this->generateReceiptToken($sale)]);
        
        return QrCode::size(200)
                    ->format('png')
                    ->generate($receiptUrl);
    }

    public function viewReceipt(Request $request, Sale $sale)
    {
        if (!$this->validateReceiptToken($sale, $request->token)) {
            abort(403, 'Invalid receipt token');
        }

        return view('receipts.mobile-view', compact('sale'));
    }

    private function generateReceiptToken(Sale $sale)
    {
        return hash_hmac('sha256', $sale->id . $sale->created_at, config('app.key'));
    }

    private function validateReceiptToken(Sale $sale, $token)
    {
        return hash_equals($this->generateReceiptToken($sale), $token);
    }
}
