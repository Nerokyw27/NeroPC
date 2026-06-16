@extends('layouts.app')

@section('title', $product->name . ' - NeroPC')

@section('content')
<div class="product-details-container">

    <div class="section-header" style="margin-bottom: 25px;">
        <h2>Detail Produk: {{ $product->name }}</h2>
        <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.products.index') : route('products.index') }}" class="btn-secondary" style="font-size: 0.8rem; padding: 6px 12px; text-decoration: none; border-radius: var(--radius-sm);">
            Kembali ke Katalog
        </a>
    </div>

    <!-- DETAILS GRID -->
    <div class="details-grid">
        <!-- LEFT: IMAGE -->
        <div class="details-image-section">
            <div class="large-image-placeholder">
                <span>{{ $product->category === 'Prebuilt PC' ? '🖥️' : '🔌' }}</span>
            </div>
        </div>

        <!-- RIGHT: INFO & ACTIONS -->
        <div class="details-info-section">
            <span class="details-cat">{{ $product->category }}</span>
            <h2>{{ $product->name }}</h2>
            <div class="details-meta">
                <span>SKU: <strong class="text-cyan">{{ $product->sku }}</strong></span>
                <span>Merek: <strong>{{ $product->brand }}</strong></span>
            </div>

            <div class="details-price-card">
                <span class="price-lbl">Harga Produk</span>
                <span class="price-val" id="product-base-price" data-price="{{ $product->price }}">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>

            <div class="details-desc">
                <h3>Deskripsi</h3>
                <p>{{ $product->description ?? 'Tidak ada deskripsi tertulis untuk produk ini.' }}</p>
            </div>

            <!-- INTERACTIVE ADD TO CART SECTION -->
            <div class="details-purchase-card">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-primary btn-block" style="text-align: center; justify-content: center; text-decoration: none;">
                        Edit Produk
                    </a>
                @elseif($product->stock > 0)
                    <div class="purchase-stock status-ok">✓ Stok Tersedia (Sisa: {{ $product->stock }} unit)</div>
                    
                    <form id="detail-add-to-cart-form" action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="purchase-quantity-box">
                            <label for="quantity-input">Jumlah</label>
                            <div class="quantity-input-wrapper">
                                <button type="button" class="qty-btn" id="qty-minus">-</button>
                                <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="{{ $product->stock }}" readonly>
                                <button type="button" class="qty-btn" id="qty-plus">+</button>
                            </div>
                        </div>

                        <!-- LIVE SUBTOTAL DISPLAY (DOM Manipulation) -->
                        <div class="live-subtotal-box">
                            <span>Subtotal:</span>
                            <strong id="live-subtotal-val">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                        </div>

                        <button type="submit" class="btn-primary btn-block btn-add-to-cart">
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="purchase-stock status-out">✕ Stok Habis</div>
                    <button type="button" class="btn-secondary btn-block disabled" disabled>
                        Stok Sedang Kosong
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- SPECIFICATIONS & REVIEWS SECTION -->
    <div class="specs-reviews-tabs">
        <div class="tabs-header">
            <h2 style="margin-top: 10px; padding-top: 10px; padding-left: 500px; padding-bottom: 10px;">Spesifikasi Hardware </h2>
            <!-- <button class="tab-btn active" data-tab="specs">Spesifikasi Hardware</button> -->
        </div>

        <!-- SPECIFICATIONS TABLE -->
        <div class="tab-content active" id="tab-specs">
            <table class="specs-table">
                <tbody>
                    @if(is_array($product->specifications) && count($product->specifications) > 0)
                        @foreach($product->specifications as $key => $val)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $val }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-muted text-center">Spesifikasi teknis tidak tersedia.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    @if($related->count() > 0)
        <div class="related-products-section">
            <div class="section-header">
                <h2>Produk Serupa</h2>
            </div>
            <div class="products-grid">
                @foreach($related as $rel)
                    <div class="product-card">
                        <div class="product-image-placeholder">
                            <span>🔌</span>
                        </div>
                        <div class="product-info-box">
                            <span class="product-cat-label">{{ $rel->category }}</span>
                            <h3 class="product-title">{{ $rel->name }}</h3>
                            <div class="product-card-footer">
                                <span class="price-val">Rp {{ number_format($rel->price, 0, ',', '.') }}</span>
                                <a href="{{ route('products.show', $rel->id) }}" class="btn-action-view">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Tab Switcher
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            tab.classList.add('active');
            const contentId = 'tab-' + tab.dataset.tab;
            document.getElementById(contentId).classList.add('active');
        });
    });

    // 2. Quantity Selector & Live Subtotal DOM Manipulation
    const qtyInput = document.getElementById('quantity-input');
    const btnMinus = document.getElementById('qty-minus');
    const btnPlus = document.getElementById('qty-plus');
    const basePriceEl = document.getElementById('product-base-price');
    const subtotalEl = document.getElementById('live-subtotal-val');

    if (qtyInput && basePriceEl && subtotalEl) {
        const basePrice = parseInt(basePriceEl.dataset.price);
        const maxStock = parseInt(qtyInput.max);

        const formatRupiah = (angka) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka).replace(',00', '');
        };

        const updateSubtotal = () => {
            const qty = parseInt(qtyInput.value);
            const subtotal = basePrice * qty;
            subtotalEl.textContent = formatRupiah(subtotal);
        };

        btnMinus.addEventListener('click', function () {
            let current = parseInt(qtyInput.value);
            if (current > 1) {
                qtyInput.value = current - 1;
                updateSubtotal();
            }
        });

        btnPlus.addEventListener('click', function () {
            let current = parseInt(qtyInput.value);
            if (current < maxStock) {
                qtyInput.value = current + 1;
                updateSubtotal();
            }
        });
    }

    // 3. AJAX Submission
    const form = document.getElementById('detail-add-to-cart-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('.btn-add-to-cart');
            const origHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>⏳</span> Menambahkan...';
            submitBtn.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    if (res.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        throw new Error('Unauthorized');
                    }
                    return res.json().then(data => { throw new Error(data.message || 'Gagal menambahkan'); });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    // Update global count
                    const badge = document.getElementById('nav-cart-count');
                    if (badge) {
                        badge.textContent = data.cart_count;
                        badge.style.display = 'inline-flex';
                    }
                    
                    // Show toast
                    if (window.showGlobalToast) {
                        window.showGlobalToast(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(err => {
                if (err.message !== 'Unauthorized') {
                    if (window.showGlobalToast) {
                        window.showGlobalToast(err.message, 'error');
                    } else {
                        alert(err.message);
                    }
                }
            })
            .finally(() => {
                submitBtn.innerHTML = origHtml;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
@endsection
