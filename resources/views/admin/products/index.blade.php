@extends('layouts.app')

@section('title', 'Katalog Produk Admin - NeroPC')

@section('content')
    <section id="daftar-section" class="daftar-section">
      <div class="section-header">
        <h2>Daftar Semua Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="btn-primary" style="font-size: 0.85rem; padding: 10px 20px;">
            Tambah Produk Baru
        </a>
      </div>

      <!-- SEARCH TOOLBAR -->
      <div class="toolbar" style="margin-bottom: 20px;">
        <form action="{{ route('admin.products.index') }}" method="GET" class="search-box" style="display: flex; width: 100%; gap: 10px;">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nama, SKU, merek atau kategori..." style="flex: 1;">
          <button type="submit" class="btn-secondary" style="padding: 0 20px;">Cari</button>
          @if(request('q'))
            <a href="{{ route('admin.products.index') }}" class="btn-reset-form" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">Reset</a>
          @endif
        </form>
      </div>

      <div class="table-wrapper" id="table-wrapper" style="display: block;">
        <table id="tabel-pc">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">SKU / Kode</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Kategori / Merek</th>
              <th scope="col">Spesifikasi Detail</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
              <th scope="col" style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-pc">
            @forelse($products as $index => $product)
              <tr id="prod-row-{{ $product->id }}">
                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                <td class="kode-cell">{{ $product->sku }}</td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    @if($product->is_recommended)
                        <span class="kategori-badge kat-high" style="font-size: 0.6rem; padding: 2px 6px; margin-left: 5px;">Rekomendasi</span>
                    @endif
                </td>
                <td>
                    <span class="kategori-badge kat-mid" style="font-size: 0.72rem;">{{ $product->category }}</span>
                    <span style="font-size: 0.72rem; display: block; color: var(--text-muted); margin-top: 2px;">{{ $product->brand }}</span>
                </td>
                <td>
                  <ul class="spec-list">
                    @if(is_array($product->specifications))
                        @foreach(array_slice($product->specifications, 0, 3) as $k => $v)
                            <li><span class="spec-label">{{ $k }}:</span> {{ $v }}</li>
                        @endforeach
                        @if(count($product->specifications) > 3)
                            <li class="text-muted" style="font-size: 0.68rem;">+ {{ count($product->specifications) - 3 }} spek lainnya</li>
                        @endif
                    @else
                        <span class="text-muted">-</span>
                    @endif
                  </ul>
                </td>
                <td class="harga-cell">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @php
                        $stokClass = 'stok-aman';
                        $stokIcon = '';
                        if ($product->stock === 0) {
                            $stokClass = 'stok-habis';
                            $stokIcon = '';
                        } elseif ($product->stock < 5) {
                            $stokClass = 'stok-menipis';
                            $stokIcon = '';
                        }
                    @endphp
                    <span class="stok-badge {{ $stokClass }}">{{ $stokIcon }} {{ $product->stock }}</span>
                </td>
                <td>
                  <div class="aksi-cell" style="display: flex; gap: 5px; flex-direction: column;">
                    <a href="{{ route('products.show', $product->id) }}" class="btn-action btn-edit" style="text-align: center; justify-content: center; text-decoration: none; background: rgba(34, 211, 238, 0.15); color: var(--cyan); border-color: rgba(34, 211, 238, 0.25);" title="Lihat detail produk">
                      Detail
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit" style="text-align: center; justify-content: center; text-decoration: none;" title="Edit produk">
                      Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }} dari database?')" style="display:block; width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" style="width: 100%; justify-content: center;" title="Hapus produk">
                          Hapus
                        </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted" style="padding: 30px;">Belum ada produk atau pencarian tidak ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="pagination-wrapper" style="margin-top: 20px;">
        {{ $products->links() }}
      </div>
    </section>
@endsection
