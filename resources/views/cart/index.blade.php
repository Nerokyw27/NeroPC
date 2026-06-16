@extends('layouts.app')

@section('title', 'Keranjang Belanja - NeroPC')

@section('content')
<div class="cart-page-container">
    <div class="section-header">
        <h2>Keranjang Belanja Anda</h2>
    </div>

    <!-- MAIN CART CONTENT -->
    @if($cartItems->count() > 0)
        <div class="cart-layout" id="cart-main-layout">
            <!-- LEFT: ITEMS LIST -->
            <div class="cart-items-wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr id="cart-row-{{ $item->id }}" data-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
                                <td>
                                    <div class="cart-product-cell">
                                        <span class="cart-item-icon">
                                            {{ $item->product->category === 'Prebuilt PC' ? '🖥️' : '🔌' }}
                                        </span>
                                        <div class="cart-item-info">
                                            <strong>
                                                <a href="{{ route('products.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                            </strong>
                                            <span class="sku">{{ $item->product->sku }}</span>
                                            <span class="category-badge-small">{{ $item->product->category }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="unit-price">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="quantity-input-wrapper quantity-cart-box">
                                        <button type="button" class="qty-btn btn-cart-qty-minus">-</button>
                                        <input type="number" class="cart-qty-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" readonly>
                                        <button type="button" class="qty-btn btn-cart-qty-plus">+</button>
                                    </div>
                                    <span class="stock-info-small">Max: {{ $item->product->stock }}</span>
                                </td>
                                <td class="item-subtotal font-bold" id="subtotal-{{ $item->id }}">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td>
                                    <button type="button" class="btn-action btn-delete btn-remove-cart-item" data-id="{{ $item->id }}">
                                        🗑️
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RIGHT: SUMMARY CARD -->
            <aside class="cart-summary">
                <div class="summary-card">
                    <h3>Ringkasan Belanja</h3>
                    
                    <div class="summary-row">
                        <span>Total Barang</span>
                        <span id="summary-total-items">{{ $cartItems->sum('quantity') }} unit</span>
                    </div>

                    <div class="summary-row font-bold total-row-divider">
                        <span>Total Harga</span>
                        <span class="total-price" id="cart-total-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-actions">
                        <a href="{{ route('checkout.index') }}" class="btn-primary btn-block">
                            Lanjutkan ke Checkout
                        </a>
                        <a href="{{ route('products.index') }}" class="btn-secondary btn-block">
                            Kembali Belanja
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    @endif

    <!-- EMPTY STATE -->
    <div class="empty-state {{ $cartItems->count() === 0 ? 'visible' : '' }}" id="cart-empty-state">
        <div class="empty-icon">🛒</div>
        <p>Keranjang belanja Anda masih kosong.</p>
        <div style="margin-top: 15px;">
            <a href="{{ route('products.index') }}" class="btn-primary">Telusuri Komponen Komputer</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const formatRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(angka).replace(',00', '');
    };

    const updateNavbarCount = (count) => {
        const badge = document.getElementById('nav-cart-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
        }
    };

    const sendCartUpdate = (cartId, quantity, inputEl, originalVal) => {
        fetch(`/cart/${cartId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(data => { throw new Error(data.message || 'Gagal mengubah kuantitas'); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Update specific row subtotal (DOM manipulation)
                document.getElementById(`subtotal-${cartId}`).textContent = formatRupiah(data.item_subtotal);
                
                // Update summary block
                document.getElementById('cart-total-price').textContent = formatRupiah(data.cart_total);
                document.getElementById('summary-total-items').textContent = data.cart_count + ' unit';
                
                // Update header badge
                updateNavbarCount(data.cart_count);
            }
        })
        .catch(err => {
            inputEl.value = originalVal; // Revert on failure
            if (window.showGlobalToast) {
                window.showGlobalToast(err.message, 'error');
            } else {
                alert(err.message);
            }
        });
    };

    // quantity manipulation
    document.querySelectorAll('.cart-table tbody tr').forEach(row => {
        const cartId = row.dataset.id;
        const minusBtn = row.querySelector('.btn-cart-qty-minus');
        const plusBtn = row.querySelector('.btn-cart-qty-plus');
        const input = row.querySelector('.cart-qty-input');
        const maxStock = parseInt(input.max);

        minusBtn.addEventListener('click', function () {
            let val = parseInt(input.value);
            if (val > 1) {
                const oldVal = val;
                input.value = val - 1;
                sendCartUpdate(cartId, val - 1, input, oldVal);
            }
        });

        plusBtn.addEventListener('click', function () {
            let val = parseInt(input.value);
            if (val < maxStock) {
                const oldVal = val;
                input.value = val + 1;
                sendCartUpdate(cartId, val + 1, input, oldVal);
            }
        });
    });

    // Delete item
    document.querySelectorAll('.btn-remove-cart-item').forEach(btn => {
        btn.addEventListener('click', function () {
            const cartId = this.dataset.id;
            
            if(!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) return;

            btn.disabled = true;

            fetch(`/cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Gagal menghapus produk');
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove row smoothly
                    const row = document.getElementById(`cart-row-${cartId}`);
                    row.remove();

                    // Check if cart is now empty
                    const remainingRows = document.querySelectorAll('.cart-table tbody tr');
                    if (remainingRows.length === 0) {
                        const layout = document.getElementById('cart-main-layout');
                        if (layout) layout.remove();
                        document.getElementById('cart-empty-state').classList.add('visible');
                    } else {
                        // Update totals
                        document.getElementById('cart-total-price').textContent = formatRupiah(data.cart_total);
                        document.getElementById('summary-total-items').textContent = data.cart_count + ' unit';
                    }

                    // Update header
                    updateNavbarCount(data.cart_count);
                    
                    if (window.showGlobalToast) {
                        window.showGlobalToast(data.message, 'success');
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                if (window.showGlobalToast) {
                    window.showGlobalToast(err.message, 'error');
                } else {
                    alert(err.message);
                }
            });
        });
    });
});
</script>
@endsection
