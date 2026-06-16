<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PcBuilderController extends Controller
{
    public function index()
    {
        // Fetch all components grouped by category for builder selection
        $categories = ['Processor', 'Motherboard', 'RAM', 'VGA', 'Storage', 'PSU', 'Casing'];
        
        $components = Product::whereIn('category', $categories)
            ->where('stock', '>', 0)
            ->get();

        // Pass to view as structured collection
        $componentsByCategory = [];
        foreach ($categories as $cat) {
            $componentsByCategory[$cat] = $components->where('category', $cat)->values();
        }

        return view('pc-builder.index', compact('componentsByCategory', 'categories'));
    }

    public function getComponents(Request $request)
    {
        $category = $request->query('category');
        
        if ($category) {
            $components = Product::where('category', $category)
                ->where('stock', '>', 0)
                ->get();
        } else {
            $components = Product::whereIn('category', ['Processor', 'Motherboard', 'RAM', 'VGA', 'Storage', 'PSU', 'Casing'])
                ->where('stock', '>', 0)
                ->get();
        }

        return response()->json($components);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $productIds = $request->product_ids;

        if (empty($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan pilih komponen terlebih dahulu.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            foreach ($productIds as $prodId) {
                $product = Product::findOrFail($prodId);

                if ($product->stock < 1) {
                    throw new \Exception("Stok komponen \"{$product->name}\" sedang habis.");
                }

                // Add to user cart
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $prodId)
                    ->first();

                if ($cartItem) {
                    if ($product->stock < $cartItem->quantity + 1) {
                        throw new \Exception("Stok komponen \"{$product->name}\" tidak mencukupi untuk ditambahkan.");
                    }
                    $cartItem->quantity += 1;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $prodId,
                        'quantity' => 1,
                    ]);
                }
            }

            DB::commit();

            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Semua komponen rakitan Anda berhasil ditambahkan ke keranjang belanja.',
                'cart_count' => $cartCount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan rakitan: ' . $e->getMessage(),
            ], 422);
        }
    }
}
