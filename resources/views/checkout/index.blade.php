@extends('layouts.app')

@section('title', 'Alamat Pengiriman & Checkout - NeroPC')

@section('content')
<div class="checkout-container">
    <div class="section-header">
        <h2>Formulir Checkout Pengiriman</h2>
        <p>Mohon isi data penerima dan alamat lengkap untuk proses pengiriman komputer/komponen Anda.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-message">{{ session('error') }}</span>
        </div>
    @endif

    <div class="checkout-layout">
        <!-- LEFT: FORM DATA -->
        <div class="checkout-form-wrapper">
            <form id="form-checkout" action="{{ route('checkout.store') }}" method="POST" class="checkout-form-grid" novalidate>
                @csrf
                <div class="form-section-label">Data Penerima Barang</div>
                
                <div class="form-group">
                    <label for="recipient_name">Nama Lengkap Penerima <span class="required">*</span></label>
                    <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" placeholder="cth: Budi Santoso" autocomplete="off">
                    <span class="error-msg" id="error-recipient-name"></span>
                </div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label for="recipient_email">Alamat Email Penerima <span class="required">*</span></label>
                        <input type="email" id="recipient_email" name="recipient_email" value="{{ old('recipient_email', auth()->user()->email) }}" placeholder="cth: budi@gmail.com" autocomplete="off">
                        <span class="error-msg" id="error-recipient-email"></span>
                    </div>

                    <div class="form-group">
                        <label for="recipient_phone">Nomor Telepon Valid <span class="required">*</span></label>
                        <input type="text" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone') }}" placeholder="cth: 081234567890" autocomplete="off">
                        <span class="error-msg" id="error-recipient-phone"></span>
                    </div>
                </div>

                <div class="form-section-label">Alamat Pengiriman</div>

                <div class="form-group">
                    <label for="shipping_address">Alamat Lengkap Rumah / Kantor <span class="required">*</span></label>
                    <textarea id="shipping_address" name="shipping_address" rows="4" placeholder="cth: Jl. Teknologi No. 88, Blok C, RT 05/RW 12, Kecamatan Sukolilo, Kota Surabaya, Jawa Timur 60111">{{ old('shipping_address') }}</textarea>
                    <span class="error-msg" id="error-shipping-address"></span>
                </div>

                <div class="checkout-actions">
                    <button type="submit" class="btn-primary" id="btn-submit-order" style="width: 100%; justify-content: center; font-size: 1rem; padding: 14px;">
                        Buat Pesanan Sekarang (Bayar di Tempat / COD)
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT: SUMMARY LIST -->
        <aside class="checkout-summary-sidebar">
            <div class="summary-card">
                <h3>Detail Pesanan Anda</h3>
                
                <div class="checkout-items-list">
                    @foreach($cartItems as $item)
                        <div class="checkout-item-row">
                            <div class="item-name">
                                <strong>{{ $item->product->name }}</strong>
                                <span class="qty">{{ $item->quantity }}x @ Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                            </div>
                            <span class="sub">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="summary-row total-row-divider font-bold">
                    <span>Total Pembayaran</span>
                    <span class="total-price text-green">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-checkout');
    const name = document.getElementById('recipient_name');
    const email = document.getElementById('recipient_email');
    const phone = document.getElementById('recipient_phone');
    const address = document.getElementById('shipping_address');

    const errName = document.getElementById('error-recipient-name');
    const errEmail = document.getElementById('error-recipient-email');
    const errPhone = document.getElementById('error-recipient-phone');
    const errAddress = document.getElementById('error-shipping-address');

    const setError = (input, errEl, msg) => {
        input.classList.add('input-error');
        errEl.textContent = msg;
    };

    const clearError = (input, errEl) => {
        input.classList.remove('input-error');
        errEl.textContent = '';
    };

    const validateEmail = (val) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(val);
    };

    const validatePhone = (val) => {
        // Must contain only digits, min length 9, max 15 (standard Indonesian mobile format check)
        const re = /^[0-9]{9,15}$/;
        return re.test(val);
    };

    // Real-time listener validations
    name.addEventListener('input', function () {
        const val = name.value.trim();
        if (!val) {
            setError(name, errName, 'Nama penerima wajib diisi');
        } else if (val.length < 3) {
            setError(name, errName, 'Nama minimal 3 karakter');
        } else {
            clearError(name, errName);
        }
    });

    email.addEventListener('input', function () {
        const val = email.value.trim();
        if (!val) {
            setError(email, errEmail, 'Email penerima wajib diisi');
        } else if (!validateEmail(val)) {
            setError(email, errEmail, 'Format email tidak valid');
        } else {
            clearError(email, errEmail);
        }
    });

    phone.addEventListener('input', function () {
        const val = phone.value.trim();
        if (!val) {
            setError(phone, errPhone, 'Nomor telepon wajib diisi');
        } else if (!validatePhone(val)) {
            setError(phone, errPhone, 'Nomor telepon tidak valid (hanya angka, 9-15 digit)');
        } else {
            clearError(phone, errPhone);
        }
    });

    address.addEventListener('input', function () {
        const val = address.value.trim();
        if (!val) {
            setError(address, errAddress, 'Alamat lengkap wajib diisi');
        } else if (val.length < 15) {
            setError(address, errAddress, 'Alamat minimal 15 karakter agar pengiriman kurir akurat');
        } else {
            clearError(address, errAddress);
        }
    });

    // Form submit check
    form.addEventListener('submit', function (e) {
        let valid = true;

        if (!name.value.trim()) {
            setError(name, errName, 'Nama penerima wajib diisi');
            valid = false;
        }

        if (!email.value.trim()) {
            setError(email, errEmail, 'Email penerima wajib diisi');
            valid = false;
        } else if (!validateEmail(email.value.trim())) {
            setError(email, errEmail, 'Format email tidak valid');
            valid = false;
        }

        if (!phone.value.trim()) {
            setError(phone, errPhone, 'Nomor telepon wajib diisi');
            valid = false;
        } else if (!validatePhone(phone.value.trim())) {
            setError(phone, errPhone, 'Nomor telepon tidak valid (hanya angka, 9-15 digit)');
            valid = false;
        }

        if (!address.value.trim()) {
            setError(address, errAddress, 'Alamat lengkap wajib diisi');
            valid = false;
        } else if (address.value.trim().length < 15) {
            setError(address, errAddress, 'Alamat minimal 15 karakter agar pengiriman kurir akurat');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        } else {
            const btn = document.getElementById('btn-submit-order');
            btn.textContent = 'Sedang Memproses Pesanan Anda...';
            btn.disabled = true;
        }
    });
});
</script>
@endsection
