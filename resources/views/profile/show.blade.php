@extends('layouts.app')

@section('title', 'Profil Saya - NeroPC')

@section('content')
<div class="auth-container">
    <div class="auth-card" style="max-width: 520px;">
        <div class="auth-header">
            <h2>Profil Saya</h2>
            <p>Informasi detail akun Anda yang terdaftar di NeroPC.</p>
        </div>

        <div class="form-section-label">Informasi Akun</div>

        <div style="display: flex; flex-direction: column; gap: 20px; margin: 20px 0;">
            <!-- Profile Info Row: Name -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <span style="color: var(--text-secondary); font-weight: 500;">Nama Lengkap</span>
                <span style="color: var(--text-primary); font-weight: 600; font-size: 0.95rem;">{{ $user->name }}</span>
            </div>

            <!-- Profile Info Row: Email -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <span style="color: var(--text-secondary); font-weight: 500;">Alamat Email</span>
                <span style="color: var(--cyan); font-weight: 600; font-size: 0.95rem;">{{ $user->email }}</span>
            </div>

            <!-- Profile Info Row: Role -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <span style="color: var(--text-secondary); font-weight: 500;">Peran (Role)</span>
                @if($user->isAdmin())
                    <span class="kategori-badge kat-high" style="font-size: 0.72rem; padding: 4px 12px;">Administrator</span>
                @else
                    <span class="kategori-badge kat-mid" style="font-size: 0.72rem; padding: 4px 12px;">Customer / Pelanggan</span>
                @endif
            </div>

            <!-- Profile Info Row: Member Since -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <span style="color: var(--text-secondary); font-weight: 500;">Terdaftar Sejak</span>
                <span style="color: var(--text-secondary); font-size: 0.86rem;">
                    {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                </span>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('profile.edit') }}" class="btn-primary btn-block" style="text-align: center; display: flex; justify-content: center; align-items: center; gap: 8px;">
                Edit Profil
            </a>
        </div>

    </div>
</div>
@endsection
