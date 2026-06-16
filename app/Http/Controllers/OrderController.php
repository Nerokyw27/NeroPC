<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('checkout.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email',
            'recipient_phone' => 'required|string|min:9|max:15',
            'shipping_address' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Process order inside database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $totalPrice = 0;

            // 1. Double check stock for all products
            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk produk \"{$product->name}\" tidak mencukupi (Sisa stok: {$product->stock}).");
                }
                $totalPrice += $product->price * $item->quantity;
            }

            // 2. Create the Order
            $orderNumber = 'NPC-' . date('YmdHis') . '-' . strtoupper(Str::random(4));
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'total_price' => $totalPrice,
                'status' => 'processing',
                'recipient_name' => $request->recipient_name,
                'recipient_email' => $request->recipient_email,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
            ]);

            // 3. Create OrderItems and deduct stock
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                // Deduct stock
                $product->stock -= $item->quantity;
                $product->save();

                // Create Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
            }

            // 4. Clear the cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', "Pesanan {$orderNumber} berhasil dibuat!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->orderBy('id', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }
}
