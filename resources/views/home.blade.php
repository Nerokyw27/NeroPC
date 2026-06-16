@extends('layouts.app')

@section('title', 'NeroPC - Toko Komputer & Perakitan PC Kustom')

@section('content')
<!-- HERO BANNER -->
<section class="hero" id="hero-banner">
  <div class="hero-bg-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>
  <div class="hero-content">
    <h2>Bangun PC Impianmu Bersama NeroPC</h2>
    <p>Rakit PC kustom secara interaktif dengan simulator canggih kami atau pilih dari ribuan komponen komputer original bergaransi resmi.</p>
    <div class="hero-actions">
        <a href="{{ route('pc-builder.index') }}" class="btn-primary hero-btn">
            Mulai Rakit PC
        </a>
        <a href="{{ route('products.index') }}" class="btn-secondary hero-btn">
            Telusuri Komponen
        </a>
    </div>
  </div>
</section>

<!-- CATEGORIES SECTION -->
<section class="categories-section">
    <div class="section-header">
        <h2>Kategori Komponen</h2>
        <p>Pilih kategori hardware untuk melihat spesifikasi lengkap</p>
    </div>
    <div class="categories-grid">
        <a href="{{ route('products.index', ['category' => 'Processor']) }}" class="category-card">
            <img src="{{ asset('images/processor.png') }}" alt="Processor">
            <h3>Processor</h3>
            <span>Intel & AMD</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'Motherboard']) }}" class="category-card">
            <img src="{{ asset('images/motherboard.png') }}" alt="Motherboard">
            <h3>Motherboard</h3>
            <span>ASUS, MSI, Gigabyte</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'RAM']) }}" class="category-card">
            <img src="{{ asset('images/memory card.png') }}" alt="RAM">
            <h3>RAM Memory</h3>
            <span>DDR4 & DDR5 Dual Channel</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'VGA']) }}" class="category-card">
            <img src="{{ asset('images/vga card.png') }}" alt="VGA">
            <h3>VGA Card</h3>
            <span>NVIDIA GeForce & AMD Radeon</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'Storage']) }}" class="category-card">
            <img src="{{ asset('images/storage.png') }}" alt="Storage">
            <h3>Storage</h3>
            <span>M.2 NVMe SSD & SATA</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'PSU']) }}" class="category-card">
            <img src="{{ asset('images/psu.png') }}" alt="PSU">
            <h3>Power Supply</h3>
            <span>80+ Gold Efficiency</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'Casing']) }}" class="category-card">
            <img src="{{ asset('images/casing.png') }}" alt="Casing">
            <h3>Casing</h3>
            <span>Airflow & Tempered Glass</span>
        </a>
    </div>
</section>

<!-- RECOMMENDED BUNDLES -->
<section class="recommended-section">
    <div class="section-header">
        <h2>Paket PC Rakitan Unggulan</h2>
        <p>Rekomendasi racikan PC siap pakai terbaik dari tim ahli NeroPC</p>
    </div>
    <div class="products-grid">
        @forelse($recommended as $product)
            <div class="product-card">
                <div class="product-badge">REKOMENDASI</div>
                <div class="product-image-placeholder">
                    <span>🖥️</span>
                </div>
                <div class="product-info-box">
                    <span class="product-cat-label">{{ $product->category }}</span>
                    <h3 class="product-title">{{ $product->name }}</h3>
                    
                    <ul class="spec-list-home">
                        @if(is_array($product->specifications))
                            @foreach(array_slice($product->specifications, 0, 4) as $key => $val)
                                <li><span class="spec-label">{{ $key }}:</span> {{ $val }}</li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="product-card-footer">
                        <div class="product-price-box">
                            <span class="price-lbl">Harga Paket</span>
                            <span class="price-val">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="product-actions-btn">
                            <a href="{{ route('products.show', $product->id) }}" class="btn-action-view" title="Detail PC">Detail</a>
                            <button type="button" class="btn-action-add btn-add-to-cart-ajax" data-product-id="{{ $product->id }}" title="Tambah ke Keranjang">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state visible">
                <div class="empty-icon">🖥️</div>
                <p>Belum ada paket PC rakitan unggulan.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
