@extends('layouts.app')

@section('title', 'Laporan Transaksi - Admin NeroPC')

@section('content')
    <section id="daftar-section" class="daftar-section">
      <div class="section-header">
        <h2>Laporan Transaksi Masuk</h2>
      </div>

      <!-- SEARCH TOOLBAR -->
      <div class="toolbar" style="margin-bottom: 20px;">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="search-box" style="display: flex; width: 100%; gap: 10px;">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nomor order, nama pelanggan, email..." style="flex: 1;">
          <button type="submit" class="btn-secondary" style="padding: 0 20px;">Cari</button>
          @if(request('q'))
            <a href="{{ route('admin.transactions.index') }}" class="btn-reset-form" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">Reset</a>
          @endif
        </form>
      </div>

      <div class="table-wrapper" id="table-wrapper" style="display: block;">
        <table id="tabel-pc">
          <thead>
            <tr>
              <th scope="col" style="width: 50px;">No</th>
              <th scope="col" style="width: 130px;">Nomor Order</th>
              <th scope="col" style="width: 140px;">Tanggal</th>
              <th scope="col">Pelanggan</th>
              <th scope="col">Alamat Pengiriman</th>
              <th scope="col" style="width: 250px;">Daftar Barang</th>
              <th scope="col" style="width: 130px;">Total Bayar</th>
              <th scope="col" style="width: 110px;">Status</th>
            </tr>
          </thead>
          <tbody id="tbody-pc">
            @forelse($orders as $index => $order)
              <tr>
                <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                <td class="kode-cell">{{ $order->order_number }}</td>
                <td style="font-size: 0.76rem;">{{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                <td>
                    <strong style="display: block;">{{ $order->recipient_name }}</strong>
                    <span style="font-size: 0.72rem; display: block; color: var(--text-secondary);">{{ $order->recipient_email }}</span>
                    <span style="font-size: 0.72rem; display: block; color: var(--text-muted); margin-top: 2px;">{{ $order->recipient_phone }}</span>
                </td>
                <td style="font-size: 0.76rem; color: var(--text-secondary); max-width: 200px; overflow-wrap: break-word; white-space: normal;">
                    {{ $order->shipping_address }}
                </td>
                <td>
                  <ul class="spec-list" style="font-size: 0.76rem; margin: 0; padding: 0; list-style-type: none;">
                    @foreach($order->items as $item)
                        <li style="margin-bottom: 6px; padding-bottom: 6px; border-bottom: 1px dashed rgba(255,255,255,0.05);">
                            <span style="display: block; font-weight: 500; color: var(--text-primary);">{{ $item->product->name }}</span>
                            <span style="font-size: 0.7rem; color: var(--text-muted);">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                  </ul>
                </td>
                <td class="harga-cell" style="font-weight: bold; font-size: 0.88rem;">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
                <td>
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="display: block;">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="if(confirm('Ubah status pesanan {{ $order->order_number }} menjadi ' + this.options[this.selectedIndex].text + '?')) { this.form.submit(); } else { this.value = '{{ $order->status }}'; }" style="padding: 6px 10px; font-size: 0.8rem; background: var(--bg-input); color: {{ $order->status == 'completed' ? 'var(--green)' : ($order->status == 'processing' ? 'var(--cyan)' : 'var(--text-primary)') }}; border: 1.5px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer; outline: none; width: auto; font-weight: 600;">
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }} style="color: var(--cyan); background: var(--bg-card);">Diproses</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }} style="color: var(--green); background: var(--bg-card);">Selesai</option>
                        </select>
                    </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted" style="padding: 30px;">Belum ada transaksi terdaftar atau pencarian tidak ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="pagination-wrapper" style="margin-top: 20px;">
        {{ $orders->links() }}
      </div>
    </section>
@endsection
