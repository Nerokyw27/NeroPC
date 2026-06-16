<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // 2. Filter by price range
        if ($request->has('price_min') && $request->price_min != '') {
            $query->where('price', '>=', intval($request->price_min));
        }
        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price', '<=', intval($request->price_max));
        }

        // 3. Filter by search query
        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%');
            });
        }

        // 4. Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Product::distinct()->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Fetch matching recommended products for detail recommendations
        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }

    public function liveSearch(Request $request)
    {
        $q = $request->input('q');

        if (empty($q) || strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Product::where('name', 'like', '%' . $q . '%')
            ->orWhere('sku', 'like', '%' . $q . '%')
            ->limit(6)
            ->get(['id', 'sku', 'name', 'price', 'category']);

        return response()->json($results);
    }
}
