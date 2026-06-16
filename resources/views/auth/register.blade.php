@extends('layouts.app')

@section('title', 'Register - NeroPC')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Daftar Akun NeroPC</h2>
            <p>Buat akun baru untuk menikmati kemudahan merakit PC secara online.</p>
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

        <form id="form-register" action="{{ route('register.post') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="cth: Budi Santoso" autocomplete="off">
                <span class="error-msg" id="error-name"></span>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="cth: budi@gmail.com" autocomplete="off">
                <span class="error-msg" id="error-email"></span>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Minimal 6 karakter">
                <span class="error-msg" id="error-password"></span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda">
                <span class="error-msg" id="error-password-conf"></span>
            </div>

            <button type="submit" class="btn-primary btn-block">
                Daftar Sekarang
            </button>
        </form>

        <div class="auth-footer">
            <p>Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-register');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordConf = document.getElementById('password_confirmation');

    const errName = document.getElementById('error-name');
    const errEmail = document.getElementById('error-email');
    const errPassword = document.getElementById('error-password');
    const errPasswordConf = document.getElementById('error-password-conf');

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
    name.addEventListener('input', function () {
        const val = name.value.trim();
        if (!val) {
            setError(name, errName, 'Nama lengkap wajib diisi');
        } else if (val.length < 3) {
            setError(name, errName, 'Nama minimal 3 karakter');
        } else {
            clearError(name, errName);
        }
    });

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
        } else if (val.length < 6) {
            setError(password, errPassword, 'Password minimal 6 karakter');
        } else {
            clearError(password, errPassword);
        }

        // Validate confirmation too if it has value
        if (passwordConf.value) {
            if (passwordConf.value !== val) {
                setError(passwordConf, errPasswordConf, 'Konfirmasi password tidak cocok');
            } else {
                clearError(passwordConf, errPasswordConf);
            }
        }
    });

    passwordConf.addEventListener('input', function () {
        const val = passwordConf.value;
        if (!val) {
            setError(passwordConf, errPasswordConf, 'Konfirmasi password wajib diisi');
        } else if (val !== password.value) {
            setError(passwordConf, errPasswordConf, 'Konfirmasi password tidak cocok');
        } else {
            clearError(passwordConf, errPasswordConf);
        }
    });

    // Form submit validation
    form.addEventListener('submit', function (e) {
        let valid = true;

        if (!name.value.trim()) {
            setError(name, errName, 'Nama lengkap wajib diisi');
            valid = false;
        }

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
        } else if (password.value.length < 6) {
            setError(password, errPassword, 'Password minimal 6 karakter');
            valid = false;
        }

        if (!passwordConf.value) {
            setError(passwordConf, errPasswordConf, 'Konfirmasi password wajib diisi');
            valid = false;
        } else if (passwordConf.value !== password.value) {
            setError(passwordConf, errPasswordConf, 'Konfirmasi password tidak cocok');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
