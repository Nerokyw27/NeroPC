@extends('layouts.app')

@section('title', 'Admin Dashboard - NeroPC')

@section('content')
    <!-- STATISTIK DASHBOARD -->
    <section id="statistik-section" class="stats-section">
      <div class="section-header">
        <h2>Dashboard Admin</h2>
        <p>Ringkasan performa penjualan dan inventaris toko NeroPC.</p>
      </div>
      <div class="stats-grid">
        @foreach($stats as $stat)
          <div class="stat-card {{ $stat['warna'] }}">
            <div class="stat-icon">{{ $stat['ikon'] }}</div>
            <div class="stat-info">
              <span class="stat-label">{{ $stat['judul'] }}</span>
              <span class="stat-number">{{ $stat['nilai'] }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </section>
@endsection
