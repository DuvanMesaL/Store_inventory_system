<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::active()->count();
        $totalSuppliers = Supplier::active()->count();
        $lowStockProducts = Product::lowStock()->count();

        $totalInventoryValue = Product::sum(DB::raw('stock_quantity * purchase_price'));
        $totalSalesValue = Product::sum(DB::raw('stock_quantity * selling_price'));

        $lowStockItems = Product::with(['category'])
                               ->lowStock()
                               ->limit(10)
                               ->get();

        $recentMovements = StockMovement::with(['product'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(10)
                                      ->get();

        $categoryStats = Category::withCount('products')->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'lowStockProducts',
            'totalInventoryValue',
            'totalSalesValue',
            'lowStockItems',
            'recentMovements',
            'categoryStats'
        ));
    }
}
