@extends('layouts.app')

@section('title', 'Edit Profil - NeroPC')

@section('content')
<div class="auth-container">
    <div class="auth-card" style="max-width: 520px;">
        <div class="auth-header" style="margin-top: 28px; padding-top: 18px; border-top: 1px solid var(--border-color); display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('profile.show') }}" style="color: var(--cyan); font-weight: 600; font-size: 0.82rem; text-decoration: none; white-space: nowrap;">
                Kembali
            </a>
            <h2 style="margin: 0; position: absolute; left: 50%; transform: translateX(-50%);">Profil Saya</h2>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <span class="alert-icon">❌</span>
                <div class="alert-message">
                    <ul style="margin: 0; padding-left: 16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form id="form-profile" action="{{ route('profile.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            

            <div class="form-section-label">Informasi Profil</div>
            
            <div class="form-group" style="margin-bottom: 16px;">
                <label for="name">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap Anda" autocomplete="off">
                <span class="error-msg" id="error-name"></span>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="email">Alamat Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan alamat email Anda" autocomplete="off">
                <span class="error-msg" id="error-email"></span>
            </div>

            <div class="form-section-label" style="margin-top: 28px;">Ubah Password</div>
            <p class="text-muted" style="font-size: 0.76rem; margin-bottom: 16px; color: var(--text-secondary);">
                Kosongkan field di bawah ini jika Anda tidak ingin mengubah password akun Anda.
            </p>
            
            <div class="form-group" style="margin-bottom: 16px;">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" placeholder="Wajib diisi jika ingin merubah password">
                <span class="error-msg" id="error-current-password"></span>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter">
                <span class="error-msg" id="error-new-password"></span>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru Anda">
                <span class="error-msg" id="error-password-conf"></span>
            </div>

            <button type="submit" class="btn-primary btn-block">
                 Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-profile');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('new_password');
    const passwordConf = document.getElementById('new_password_confirmation');

    const errName = document.getElementById('error-name');
    const errEmail = document.getElementById('error-email');
    const errCurrentPassword = document.getElementById('error-current-password');
    const errNewPassword = document.getElementById('error-new-password');
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

    newPassword.addEventListener('input', function () {
        const val = newPassword.value;
        if (val) {
            if (val.length < 6) {
                setError(newPassword, errNewPassword, 'Password baru minimal 6 karakter');
            } else {
                clearError(newPassword, errNewPassword);
            }
            
            // Check if current password is empty
            if (!currentPassword.value) {
                setError(currentPassword, errCurrentPassword, 'Password saat ini wajib diisi jika ingin merubah password');
            } else {
                clearError(currentPassword, errCurrentPassword);
            }
        } else {
            clearError(newPassword, errNewPassword);
            if (!passwordConf.value) {
                clearError(currentPassword, errCurrentPassword);
            }
        }

        // Validate confirmation too if it has value
        if (passwordConf.value) {
            if (passwordConf.value !== val) {
                setError(passwordConf, errPasswordConf, 'Konfirmasi password baru tidak cocok');
            } else {
                clearError(passwordConf, errPasswordConf);
            }
        }
    });

    currentPassword.addEventListener('input', function () {
        const val = currentPassword.value;
        if (!val && (newPassword.value || passwordConf.value)) {
            setError(currentPassword, errCurrentPassword, 'Password saat ini wajib diisi jika ingin merubah password');
        } else {
            clearError(currentPassword, errCurrentPassword);
        }
    });

    passwordConf.addEventListener('input', function () {
        const val = passwordConf.value;
        if (val) {
            if (val !== newPassword.value) {
                setError(passwordConf, errPasswordConf, 'Konfirmasi password baru tidak cocok');
            } else {
                clearError(passwordConf, errPasswordConf);
            }

            // Check if current password is empty
            if (!currentPassword.value) {
                setError(currentPassword, errCurrentPassword, 'Password saat ini wajib diisi jika ingin merubah password');
            } else {
                clearError(currentPassword, errCurrentPassword);
            }
        } else {
            clearError(passwordConf, errPasswordConf);
            if (!newPassword.value) {
                clearError(currentPassword, errCurrentPassword);
            }
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

        // If new password is filled or password conf is filled
        if (newPassword.value || passwordConf.value) {
            if (!currentPassword.value) {
                setError(currentPassword, errCurrentPassword, 'Password saat ini wajib diisi jika ingin merubah password');
                valid = false;
            }
            
            if (newPassword.value.length < 6) {
                setError(newPassword, errNewPassword, 'Password baru minimal 6 karakter');
                valid = false;
            }

            if (passwordConf.value !== newPassword.value) {
                setError(passwordConf, errPasswordConf, 'Konfirmasi password baru tidak cocok');
                valid = false;
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
