@extends('layouts.app')

@section('title', 'Riwayat Transaksi Saya - NeroPC')

@section('content')
<div class="orders-history-container">
    <div class="section-header" style="flex-direction: column; align-items: flex-start; gap: 5px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 25px;">
        <h2 style="margin: 0; font-size: 1.4rem;">Riwayat Transaksi Saya</h2>
        <p class="text-muted" style="margin: 0; font-size: 0.84rem; color: var(--text-secondary);">Pantau status pengiriman dan riwayat perakitan PC yang telah Anda pesan.</p>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-history-card">
                    <div class="order-card-header">
                        <div class="header-left">
                            <span class="order-date">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                            <h3 class="order-number text-cyan">{{ $order->order_number }}</h3>
                        </div>
                        @if($order->status == 'completed')
                            <span class="order-status-badge">Selesai (COD)</span>
                        @elseif($order->status == 'processing')
                            <span class="order-status-badge" style="color: var(--cyan); background: rgba(34, 211, 238, 0.08); border: 1px solid rgba(34, 211, 238, 0.2);">Diproses</span>
                        @else
                            <span class="order-status-badge" style="color: var(--amber); background: rgba(251, 191, 36, 0.08); border: 1px solid rgba(251, 191, 36, 0.2);">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                    
                    <div class="order-card-body">
                        <!-- Left info -->
                        <div class="order-shipping-info">
                            <h4>Alamat Pengiriman:</h4>
                            <p><strong>{{ $order->recipient_name }}</strong> ({{ $order->recipient_phone }})</p>
                            <p class="text-muted">{{ $order->shipping_address }}</p>
                        </div>

                        <!-- Right items list -->
                        <div class="order-items-summary">
                            <h4>Daftar Barang ({{ $order->items->sum('quantity') }} Unit):</h4>
                            <ul class="ordered-items-list">
                                @foreach($order->items as $item)
                                    <li>
                                        <div class="item-name-qty">
                                            <span>{{ $item->product->name }}</span>
                                            <span class="qty text-muted">{{ $item->quantity }}x</span>
                                        </div>
                                        <span class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="order-card-footer">
                        <span>Total Pembayaran COD</span>
                        <strong class="total text-green">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state visible">
            <div class="empty-icon">📜</div>
            <p>Anda belum memiliki riwayat pemesanan.</p>
            <div style="margin-top: 15px;">
                <a href="{{ route('products.index') }}" class="btn-primary">Ayo Belanja Komponen</a>
            </div>
        </div>
    @endif
</div>
@endsection
