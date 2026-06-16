<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PcController extends Controller
{
    /**
     * Tampilkan halaman utama (Landing Page)
     */
    public function index()
    {
        $recommended = Product::where('is_recommended', true)
            ->where('stock', '>', 0)
            ->get();

        return view('home', compact('recommended'));
    }
}
