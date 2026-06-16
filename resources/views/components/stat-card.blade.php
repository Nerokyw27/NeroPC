@props(['judul', 'nilai', 'ikon', 'warna' => ''])

<div class="stat-card {{ $warna }}">
  <div class="stat-icon">{{ $ikon }}</div>
  <div class="stat-info">
    <span class="stat-label">{{ $judul }}</span>
    <span class="stat-number">{{ $nilai }}</span>
  </div>
</div>
