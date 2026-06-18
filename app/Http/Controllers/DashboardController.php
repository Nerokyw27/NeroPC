<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy data untuk statistik
        $stats = [
            ['judul' => 'Total Produk', 'nilai' => 125, 'ikon' => 'fas fa-desktop', 'warna' => 'primary'],
            ['judul' => 'Kategori', 'nilai' => 5, 'ikon' => 'fas fa-tags', 'warna' => 'success'],
            ['judul' => 'Stok Habis', 'nilai' => 3, 'ikon' => 'fas fa-box-open', 'warna' => 'danger'],
            ['judul' => 'Penjualan', 'nilai' => 'Rp 50M', 'ikon' => 'fas fa-chart-line', 'warna' => 'warning'],
        ];

        return view('dashboard', compact('stats'));
    }
}
