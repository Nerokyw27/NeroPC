@extends('layouts.app')

@section('title', 'Katalog Komponen Komputer & PC Rakitan - NeroPC')

@section('content')
<div class="catalog-layout">
    <!-- SIDEBAR FILTER -->
    <aside class="catalog-sidebar">
        <div class="sidebar-header">
            <h3>Filter Produk</h3>
            <a href="{{ route('products.index') }}" class="clear-filters-btn">Reset</a>
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="filter-form">
            <!-- Retain current query inputs except ones being edited -->
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <div class="filter-group">
                <label for="search-filter">Kata Kunci</label>
                <input type="text" id="search-filter" name="q" value="{{ request('q') }}" placeholder="Cari nama, brand, SKU...">
            </div>

            <div class="filter-group">
                <label for="category-filter">Kategori</label>
                <select id="category-filter" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Batas Harga (Rp)</label>
                <div class="price-range-inputs">
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min" min="0">
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max" min="0">
                </div>
            </div>

            <button type="submit" class="btn-primary btn-block">
                Terapkan Filter
            </button>
        </form>
    </aside>

    <!-- PRODUCT CATALOG CONTENT -->
    <div class="catalog-main">
        <div class="catalog-toolbar">
            <div class="results-count">
                Menampilkan <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> dari <strong>{{ $products->total() }}</strong> produk
            </div>
            
            <div class="sort-box">
                <label for="sort-select">Urutkan:</label>
                <select id="sort-select" onchange="location = this.value;">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" {{ request('sort') == 'default' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama: Z - A</option>
                </select>
            </div>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                @php
                    $isPrebuilt = $product->category === 'Prebuilt PC';
                    
                    $stokClass = 'stok-aman';
                    $stokText = "Stok: {$product->stock}";
                    if ($product->stock === 0) {
                        $stokClass = 'stok-habis';
                        $stokText = 'Stok Habis';
                    } elseif ($product->stock < 5) {
                        $stokClass = 'stok-menipis';
                        $stokText = "Stok Sisa {$product->stock}";
                    }
                @endphp

                <div class="product-card">
                    @if($product->is_recommended)
                        <div class="product-badge">REKOMENDASI</div>
                    @endif
                    <div class="product-image-placeholder">
                        <span>{{ $isPrebuilt ? '🖥️' : '🔌' }}</span>
                    </div>
                    <div class="product-info-box">
                        <span class="product-cat-label">{{ $product->category }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <span class="product-sku-label">{{ $product->sku }}</span>
                        
                        <ul class="spec-list-home">
                            @if(is_array($product->specifications))
                                @foreach(array_slice($product->specifications, 0, 3) as $key => $val)
                                    <li><span class="spec-label">{{ $key }}:</span> {{ $val }}</li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="product-card-footer">
                            <div class="product-price-box">
                                <span class="price-val">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="badge-stock-catalog {{ $stokClass }}">{{ $stokText }}</span>
                            </div>
                            <div class="product-actions-btn" style="gap: 10px;">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-action-view" title="Detail Produk">Detail</a>
                                @if($product->stock > 0)
                                    <button type="button" class="btn-action-add btn-add-to-cart-ajax" data-product-id="{{ $product->id }}" title="Tambah ke Keranjang">
                                        +
                                    </button>
                                @else
                                    <button type="button" class="btn-action-add disabled" disabled title="Stok Habis">
                                        ❌
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state visible">
                    <div class="empty-icon">🔌</div>
                    <p>Produk tidak ditemukan. Silakan ganti filter atau kata kunci Anda.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
