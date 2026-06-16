@php
  $cartCount = 0;
  if(auth()->check()) {
      $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
  }
@endphp

<!-- HEADER -->
<header id="app-header">
  <div class="header-brand">
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('images/logo sementara.png') }}" alt="Logo NeroPC" width="44" height="44">
      <div class="header-text">
        <h1>NeroPC</h1>
        <p>Custom PC & Components</p>
      </div>
    </a>
  </div>

  @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Admin Navigation (No Search Bar) -->
    <nav aria-label="Navigasi Admin">
      <ul style="display: flex; gap: 10px; align-items: center; list-style: none;">
        <li>
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            Profil
          </a>
        </li>
        <li>
          <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            Tambah Produk
          </a>
        </li>
        <li>
          <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
            Katalog
          </a>
        </li>
        <li>
          <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
            Laporan Transaksi
          </a>
        </li>
        <li>
          <button id="theme-toggle-admin" class="nav-link theme-toggle-btn" style="background: none; border: none; cursor: pointer; font-size: 1.15rem; padding: 8px 12px; display: inline-flex; align-items: center; justify-content: center; color: var(--text-secondary);" title="Ganti Tema">
            <span class="theme-toggle-icon">🌙</span>
          </button>
        </li>
        <li>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" style="color: var(--red);">
            Keluar
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
  @else
    <!-- Guest & Customer Navigation -->
    <!-- LIVE SEARCH BAR -->
    <div class="navbar-search">
      <div class="search-input-wrapper">
        <span class="search-icon-nav">🔍</span>
        <input type="text" id="nav-search-input" placeholder="Cari prosesor, VGA, RAM..." autocomplete="off">
        <button type="button" class="clear-search-btn" id="nav-clear-search" style="display:none;">✕</button>
      </div>
      <!-- Suggestions Dropdown -->
      <div class="search-suggestions-dropdown" id="nav-search-suggestions"></div>
    </div>

    <nav aria-label="Navigasi Utama">
      <ul>
        <li>
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            Beranda
          </a>
        </li>
        <li>
          <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            Katalog
          </a>
        </li>
        <li>
          <a href="{{ route('pc-builder.index') }}" class="nav-link {{ request()->routeIs('pc-builder.*') ? 'active' : '' }}">
            Rakit PC
          </a>
        </li>

        @auth
          <!-- Shopping Cart Icon -->
          <li>
            <a href="{{ route('cart.index') }}" class="nav-link nav-cart-btn {{ request()->routeIs('cart.*') ? 'active' : '' }}">
              Keranjang
              <span class="cart-badge" id="nav-cart-count">{{ $cartCount }}</span>
            </a>
          </li>

          <!-- User Menu Dropdown (Simplified) -->
          <li class="user-menu-item">
            <span class="user-greeting">{{ auth()->user()->name }}</span>
            <div class="user-submenu">
              <a href="{{ route('profile.show') }}">Profil Saya</a>
              <a href="{{ route('orders.index') }}">Transaksi Saya</a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Keluar
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @else
          <!-- Guest Auth Buttons -->
          <li>
            <a href="{{ route('login') }}" class="btn-auth-nav btn-login-nav">Masuk</a>
          </li>
          <li>
            <a href="{{ route('register') }}" class="btn-auth-nav btn-register-nav">Daftar</a>
          </li>
        @endauth
        <li>
          <button id="theme-toggle-client" class="nav-link theme-toggle-btn" style="background: none; border: none; cursor: pointer; font-size: 1.15rem; padding: 8px 12px; display: inline-flex; align-items: center; justify-content: center; color: var(--text-secondary);" title="Ganti Tema">
            <span class="theme-toggle-icon">🌙</span>
          </button>
        </li>
      </ul>
    </nav>
  @endif
</header>
