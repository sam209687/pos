<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\PaymentMethod;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;
use DB;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::where('status', true)
            ->where('quantity', '>', 0)
            ->with(['category', 'brand'])
            ->get();
            
        $paymentMethods = PaymentMethod::where('status', true)->get();
        
        return view('pos.index', compact('products', 'paymentMethods'));
    }

    public function getProduct(Request $request)
    {
        $product = Product::where('code', $request->code)
            ->where('status', true)
            ->where('quantity', '>', 0)
            ->first();
            
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        return response()->json($product);
    }

    public function processSale(SaleRequest $request)
    {
        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'payment_method_id' => $request->payment_method_id,
                'total_amount' => $request->total_amount,
                'discount_amount' => $request->discount_amount,
                'tax_amount' => $request->tax_amount,
                'final_amount' => $request->final_amount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->change_amount,
                'sale_date' => now()->toDateString(),
                'sale_time' => now()->toTimeString(),
                'notes' => $request->notes,
                'status' => 'completed'
            ]);

            foreach ($request->items as $item) {
                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update product quantity
                Product::where('id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'message' => 'Sale completed successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error processing sale'
            ], 500);
        }
    }
}
