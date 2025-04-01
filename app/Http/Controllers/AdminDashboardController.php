<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Sale::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_revenue' => Sale::sum('final_amount'),
        ];

        $recent_sales = Sale::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_sales'));
    }
} 