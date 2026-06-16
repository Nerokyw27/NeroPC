<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = intval($request->quantity);

        $product = Product::findOrFail($productId);

        // Check stock
        if ($product->stock < $quantity) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk tidak mencukupi. Tersedia: {$product->stock}.",
                ], 422);
            }
            return back()->with('error', "Stok tidak cukup. Tersedia: {$product->stock}.");
        }

        // Find or create cart item
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok produk tidak mencukupi jika ditambahkan ke keranjang. Tersedia: {$product->stock}.",
                    ], 422);
                }
                return back()->with('error', "Stok tidak cukup untuk penambahan ini.");
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "\"{$product->name}\" berhasil ditambahkan ke keranjang.",
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', "\"{$product->name}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Cart $cart)
    {
        // Ensure user owns this cart item
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = intval($request->quantity);
        $product = $cart->product;

        // Check stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => "Stok tidak cukup. Maksimal pembelian: {$product->stock}.",
            ], 422);
        }

        $cart->quantity = $quantity;
        $cart->save();

        // Calculate new totals
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        $itemSubtotal = $product->price * $quantity;
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'item_subtotal' => $itemSubtotal,
            'cart_total' => $totalPrice,
            'cart_count' => $cartCount,
        ]);
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $productName = $cart->product->name;
        $cart->delete();

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }
        $cartCount = $cartItems->sum('quantity');

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "\"{$productName}\" dihapus dari keranjang.",
                'cart_total' => $totalPrice,
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', "\"{$productName}\" dihapus.");
    }
}
