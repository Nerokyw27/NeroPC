<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NeroPC - Platform E-Commerce Perakitan dan Penjualan PC Terpercaya. Rakit komputermu sendiri secara interaktif.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
      document.documentElement.setAttribute('data-theme', 'light');
    } else {
      document.documentElement.setAttribute('data-theme', 'dark');
    }
  </script>
  <title>@yield('title', 'NeroPC - Solusi Rakit PC & Komponen Komputer')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  @include('partials.navbar')

  <!-- MAIN CONTENT -->
  <main class="main-container">
    @if(session('success'))
      <div class="alert alert-success">
        <span class="alert-icon">✅</span>
        <span class="alert-message">{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        <span class="alert-icon">❌</span>
        <span class="alert-message">{{ session('error') }}</span>
      </div>
    @endif

    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer id="kontak">
    <section class="footer-grid">

      <section class="footer-col">
        <div class="footer-brand">
          <img src="{{ asset('images/logo sementara.png') }}" alt="Logo NeroPC" width="40" height="40">
          <h3>NeroPC</h3>
        </div>
        <p>Platform penjualan komponen komputer dan perakitan PC kustom terpercaya dengan simulasi harga real-time.</p>
      </section>

      <nav class="footer-col" aria-label="Menu Cepat">
        <h3>Menu</h3>
        <ul>
          @if(auth()->check() && auth()->user()->isAdmin())
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('profile.show') }}">Profil</a></li>
            <li><a href="{{ route('admin.products.create') }}">Tambah Produk</a></li>
            <li><a href="{{ route('admin.products.index') }}">Katalog</a></li>
            <li><a href="{{ route('admin.transactions.index') }}">Laporan Transaksi</a></li>
          @else
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('products.index') }}">Katalog</a></li>
            <li><a href="{{ route('pc-builder.index') }}">Rakit PC</a></li>
            @auth
              <li><a href="{{ route('cart.index') }}">Keranjang</a></li>
              <li><a href="{{ route('profile.show') }}">Profil Saya</a></li>
              <li><a href="{{ route('orders.index') }}">Transaksi Saya</a></li>
            @endauth
          @endif
        </ul>
      </nav>

      <address class="footer-col" style="font-style: normal;">
        <h3>Kontak NeroPC</h3>
        <p>Email: support@neropc.com</p>
        <p>Telepon: (021) 5678-1234</p>
        <p>Alamat: IT Center Lt. 3 No. 45,<br>Jakarta Barat, DKI Jakarta</p>
        <p>Jam Kerja: Setiap Hari, 09.00 - 21.00 WIB</p>
      </address>

    </section>
    <p class="footer-copy">&copy; 2026 NeroPC. All rights reserved.</p>
  </footer>

  <!-- TOAST NOTIFICATION CONTAINER -->
  <div id="toast-container"></div>

  @stack('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const toggleButtons = document.querySelectorAll('.theme-toggle-btn');
      
      const updateThemeUI = () => {
          const isLight = document.documentElement.getAttribute('data-theme') === 'light';
          document.querySelectorAll('.theme-toggle-icon').forEach(icon => {
              icon.textContent = isLight ? '☀️' : '🌙';
          });
          document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
              btn.title = isLight ? 'Ganti ke Mode Gelap' : 'Ganti ke Mode Terang';
          });
      };
      
      updateThemeUI();
      
      toggleButtons.forEach(btn => {
          btn.addEventListener('click', () => {
              const currentTheme = document.documentElement.getAttribute('data-theme');
              const newTheme = currentTheme === 'light' ? 'dark' : 'light';
              
              document.documentElement.setAttribute('data-theme', newTheme);
              localStorage.setItem('theme', newTheme);
              updateThemeUI();
          });
      });
  });
  </script>
</body>
</html>
