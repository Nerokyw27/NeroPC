@extends('layouts.app')

@section('title', 'Login - NeroPC')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Masuk ke NeroPC</h2>
            <p>Silakan masuk menggunakan akun Anda untuk melanjutkan transaksi.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-login" action="{{ route('login.post') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="cth: budi@gmail.com" autocomplete="off">
                <span class="error-msg" id="error-email"></span>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda">
                <span class="error-msg" id="error-password"></span>
            </div>


            <button type="submit" class="btn-primary btn-block">
                Masuk Sekarang
            </button>
        </form>

        <div class="auth-footer">
            <p>Belum memiliki akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-login');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const errEmail = document.getElementById('error-email');
    const errPassword = document.getElementById('error-password');

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

    // Real-time validations
    email.addEventListener('input', function () {
        const val = email.value.trim();
        if (!val) {
            setError(email, errEmail, 'Email wajib diisi');
        } else if (!validateEmail(val)) {
            setError(email, errEmail, 'Format email tidak valid');
        } else {
            clearError(email, errEmail);
        }
    });

    password.addEventListener('input', function () {
        const val = password.value;
        if (!val) {
            setError(password, errPassword, 'Password wajib diisi');
        } else {
            clearError(password, errPassword);
        }
    });

    // Form submit validation
    form.addEventListener('submit', function (e) {
        let valid = true;

        if (!email.value.trim()) {
            setError(email, errEmail, 'Email wajib diisi');
            valid = false;
        } else if (!validateEmail(email.value.trim())) {
            setError(email, errEmail, 'Format email tidak valid');
            valid = false;
        }

        if (!password.value) {
            setError(password, errPassword, 'Password wajib diisi');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
