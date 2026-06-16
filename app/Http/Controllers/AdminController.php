<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard stats summary.
     */
    public function dashboard()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $products = Product::all();
        
        // Calculations
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $outOfStock = $products->where('stock', 0)->count();
        $inventoryValue = $products->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->stock);
        }, 0);

        $totalOrders = Order::count();
        $lowStock = $products->where('stock', '>', 0)->where('stock', '<', 5)->count();

        $stats = [
            ['judul' => 'Total Jenis Produk', 'nilai' => $totalProducts, 'ikon' => '🖥️', 'warna' => 'stat-total'],
            ['judul' => 'Jumlah Total Stok', 'nilai' => $totalStock, 'ikon' => '📦', 'warna' => 'stat-stock'],
            ['judul' => 'Stok Habis', 'nilai' => $outOfStock, 'ikon' => '🔴', 'warna' => 'stat-sold'],
            ['judul' => 'Nilai Inventaris', 'nilai' => 'Rp ' . number_format($inventoryValue, 0, ',', '.'), 'ikon' => '💰', 'warna' => 'stat-revenue'],
            ['judul' => 'Total Transaksi', 'nilai' => $totalOrders, 'ikon' => '📊', 'warna' => 'stat-orders'],
            ['judul' => 'Stok Menipis (<5)', 'nilai' => $lowStock, 'ikon' => '⚠️', 'warna' => 'stat-warning'],
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display the admin products catalog for management.
     */
    public function catalog(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $query = Product::orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form to create a new product.
     */
    public function createProduct()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in database.
     */
    public function storeProduct(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $request->validate([
            'sku' => 'required|string|unique:products,sku',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'spec_keys' => 'nullable|array',
            'spec_vals' => 'nullable|array',
        ]);

        // Process specifications array into JSON
        $specifications = [];
        if ($request->has('spec_keys') && $request->has('spec_vals')) {
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key) && isset($request->spec_vals[$index])) {
                    $specifications[$key] = $request->spec_vals[$index];
                }
            }
        }

        Product::create([
            'sku' => strtoupper($request->sku),
            'name' => $request->name,
            'category' => $request->category,
            'brand' => $request->brand,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'specifications' => empty($specifications) ? null : $specifications,
            'is_recommended' => $request->has('is_recommended'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Show the form to edit an existing product.
     */
    public function editProduct(Product $product)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update an existing product in database.
     */
    public function updateProduct(Request $request, Product $product)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $request->validate([
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'spec_keys' => 'nullable|array',
            'spec_vals' => 'nullable|array',
        ]);

        // Process specifications
        $specifications = [];
        if ($request->has('spec_keys') && $request->has('spec_vals')) {
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key) && isset($request->spec_vals[$index])) {
                    $specifications[$key] = $request->spec_vals[$index];
                }
            }
        }

        $product->update([
            'sku' => strtoupper($request->sku),
            'name' => $request->name,
            'category' => $request->category,
            'brand' => $request->brand,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'specifications' => empty($specifications) ? null : $specifications,
            'is_recommended' => $request->has('is_recommended'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Remove a product from database.
     */
    public function destroyProduct(Product $product)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Display all transactions (Orders report).
     */
    public function transactions(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $query = Order::with(['user', 'items.product'])->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%")
                  ->orWhere('recipient_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.transactions.index', compact('orders'));
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman khusus Administrator.');
        }

        $request->validate([
            'status' => 'required|string|in:processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan ' . $order->order_number . ' berhasil diperbarui.');
    }
}
