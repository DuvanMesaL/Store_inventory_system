<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product.category'])
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(20);

        return view('stock-movements.index', compact('movements'));
    }

    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['product.category', 'product.supplier']);

        return view('stock-movements.show', compact('stockMovement'));
    }

    public function create(Product $product = null)
    {
        $products = Product::with(['category', 'supplier'])
                          ->active()
                          ->orderBy('name')
                          ->get();

        return view('stock-movements.create', compact('products', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:100'
        ]);

        $product = Product::findOrFail($request->product_id);

        try {
            $product->updateStock(
                $request->quantity,
                $request->type,
                $request->reason,
                $request->reference
            );

            return redirect()->route('stock-movements.index')
                           ->with('success', 'Movimiento de stock registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())
                        ->withInput();
        }
    }
}
