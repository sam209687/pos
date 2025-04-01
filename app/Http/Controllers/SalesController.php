<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Excel;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'paymentMethod', 'items.product']);

        // Date range filtering
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('sale_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // Status filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sales = $query->latest()->paginate(10);
        
        $totalSales = $query->sum('final_amount');
        $totalItems = $query->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->sum('sale_items.quantity');

        return view('sales.index', compact('sales', 'totalSales', 'totalItems'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'paymentMethod', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    public function exportPDF(Request $request)
    {
        $sales = $this->getSalesForExport($request);
        $pdf = PDF::loadView('sales.export.pdf', compact('sales'));
        return $pdf->download('sales-report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $sales = $this->getSalesForExport($request);
        return Excel::download(new SalesExport($sales), 'sales-report.xlsx');
    }

    private function getSalesForExport(Request $request)
    {
        $query = Sale::with(['user', 'paymentMethod', 'items.product']);

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('sale_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        return $query->get();
    }
}
