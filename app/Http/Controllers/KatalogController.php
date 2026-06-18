<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        // Tampilkan hanya PC buatan Admin (misal user_id 1 atau role admin)
        // Disini kita akan ambil semua yang tersedia dan dibuat oleh admin
        $pcs = Pc::whereHas('user', function($query) {
            $query->where('role', 'admin');
        })->latest()->paginate(12);

        return view('katalog.index', compact('pcs'));
    }

    public function show(Pc $pc)
    {
        return view('katalog.show', compact('pc'));
    }
}
