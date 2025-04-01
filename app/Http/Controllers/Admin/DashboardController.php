<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Sale::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_revenue' => Sale::sum('final_amount'),
        ];

        $recent_sales = Sale::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_sales'));
    }
} 