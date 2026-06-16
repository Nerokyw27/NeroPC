@extends('layouts.app')

@section('title', 'Simulator Rakit PC Kustom - NeroPC')

@section('content')
<div class="pc-builder-container">
    <div class="section-header">
        <h2>Simulator Rakit PC Kustom</h2>
        <p>Pilih komponen satu per satu untuk merakit PC kustom Anda secara interaktif.</p>
    </div>

    <!-- MAIN BUILDER LAYOUT -->
    <div class="builder-layout">
        <!-- LEFT: SLOTS LIST -->
        <div class="builder-slots">
            @foreach($categories as $category)
                <div class="slot-card" data-category="{{ $category }}" id="slot-{{ strtolower($category) }}">
                    <div class="slot-icon" style="display: flex; align-items: center; justify-content: center;">
                        @switch($category)
                            @case('Processor')
                                <img src="{{ asset('images/processor.png') }}" alt="Processor" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('Motherboard')
                                <img src="{{ asset('images/motherboard.png') }}" alt="Motherboard" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('RAM')
                                <img src="{{ asset('images/memory card.png') }}" alt="RAM" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('VGA')
                                <img src="{{ asset('images/vga card.png') }}" alt="VGA" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('Storage')
                                <img src="{{ asset('images/storage.png') }}" alt="Storage" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('PSU')
                                <img src="{{ asset('images/psu.png') }}" alt="PSU" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                            @case('Casing')
                                <img src="{{ asset('images/casing.png') }}" alt="Casing" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px var(--accent-glow));">
                                @break
                        @endswitch
                    </div>
                    <div class="slot-info">
                        <span class="slot-label">{{ $category }}</span>
                        <div class="slot-details" id="details-{{ strtolower($category) }}">
                            <span class="empty-text">Belum memilih komponen</span>
                        </div>
                    </div>
                    <div class="slot-actions">
                        <button type="button" class="btn-action btn-choose-part" data-category="{{ $category }}">
                            Pilih
                        </button>
                        <button type="button" class="btn-action btn-delete btn-clear-part" style="display:none;" data-category="{{ $category }}">
                            ✕
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- RIGHT: SUMMARY SIDEBAR -->
        <aside class="builder-summary">
            <div class="summary-card">
                <h3>Ringkasan Rakitan</h3>
                
                <div class="summary-price-box">
                    <span class="lbl">Estimasi Total Harga</span>
                    <strong class="total-price" id="build-total-price">Rp 0</strong>
                </div>

                <div class="summary-actions">
                    <button type="button" class="btn-primary btn-block" id="btn-add-build-to-cart">
                        Masukkan Semua ke Keranjang
                    </button>
                    <button type="button" class="btn-secondary btn-block" id="btn-reset-build">
                        Reset Rakitan
                    </button>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- PART SELECTION MODAL -->
<div class="modal-overlay" id="parts-modal-overlay">
    <div class="modal-box modal-large">
        <div class="modal-header">
            <h3 id="modal-category-title">Pilih Komponen</h3>
            <button type="button" class="close-modal-btn" id="btn-close-modal">✕</button>
        </div>
        <div class="modal-search-bar">
            <input type="text" id="modal-search-input" placeholder="Cari berdasarkan nama atau brand...">
        </div>
        <div class="modal-content-scroll">
            <table class="modal-parts-table">
                <thead>
                    <tr>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Spesifikasi</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="modal-parts-body">
                    <!-- Dynamic rendering -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- EMBED DATA AS JSON -->
<script id="components-data" type="application/json">
    {!! json_encode($componentsByCategory) !!}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Load data
    const rawData = document.getElementById('components-data').textContent;
    const components = JSON.parse(rawData);

    // 2. State
    let currentBuild = {
        'Processor': null,
        'Motherboard': null,
        'RAM': null,
        'VGA': null,
        'Storage': null,
        'PSU': null,
        'Casing': null
    };

    let activeCategory = null;

    // DOM Elements
    const partsModal = document.getElementById('parts-modal-overlay');
    const modalTitle = document.getElementById('modal-category-title');
    const modalBody = document.getElementById('modal-parts-body');
    const modalSearchInput = document.getElementById('modal-search-input');
    const btnCloseModal = document.getElementById('btn-close-modal');

    const totalPriceEl = document.getElementById('build-total-price');

    const formatRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(angka).replace(',00', '');
    };

    // Calculate Price
    const calculateTotals = () => {
        let total = 0;
        for (const cat in currentBuild) {
            if (currentBuild[cat]) {
                total += currentBuild[cat].price;
            }
        }
        totalPriceEl.textContent = formatRupiah(total);
    };

    // Open Modal
    const openModal = (category) => {
        activeCategory = category;
        modalTitle.textContent = `Pilih ${category}`;
        modalSearchInput.value = '';
        renderModalParts();
        partsModal.classList.add('active');
    };

    const renderModalParts = (filterStr = '') => {
        const list = components[activeCategory] || [];
        const filtered = list.filter(item => {
            return item.name.toLowerCase().includes(filterStr.toLowerCase()) || 
                   item.brand.toLowerCase().includes(filterStr.toLowerCase());
        });

        if (filtered.length === 0) {
            modalBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Komponen tidak tersedia atau stok habis.</td></tr>';
            return;
        }

        modalBody.innerHTML = filtered.map(item => {
            let specsText = '';
            if (item.specifications) {
                specsText = Object.entries(item.specifications)
                    .map(([k, v]) => `<strong>${k}</strong>: ${v}`)
                    .join(' | ');
            }

            return `
                <tr>
                    <td>
                        <div class="part-name-box">
                            <strong>${item.name}</strong>
                            <span class="part-sku">${item.sku}</span>
                        </div>
                    </td>
                    <td class="part-specs-cell">${specsText}</td>
                    <td class="harga-cell">${formatRupiah(item.price)}</td>
                    <td>
                        <button type="button" class="btn-action btn-choose-this-part" data-id="${item.id}">
                            Pilih
                        </button>
                    </td>
                </tr>
            `;
        }).join('');

        // Attach listeners to choose buttons
        document.querySelectorAll('.btn-choose-this-part').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = parseInt(this.dataset.id);
                selectPart(id);
            });
        });
    };

    // Select Part
    const selectPart = (id) => {
        const part = components[activeCategory].find(c => c.id === id);
        if (!part) return;

        currentBuild[activeCategory] = part;

        // Update slot details DOM
        const detailsEl = document.getElementById(`details-${activeCategory.toLowerCase()}`);
        const slotEl = document.getElementById(`slot-${activeCategory.toLowerCase()}`);
        
        let specsText = '';
        if (part.specifications) {
            specsText = Object.entries(part.specifications)
                .map(([k, v]) => `${k}: ${v}`)
                .slice(0, 2)
                .join(', ');
        }

        detailsEl.innerHTML = `
            <div class="selected-part-details">
                <strong>${part.name}</strong>
                <span class="price">${formatRupiah(part.price)}</span>
                <span class="specs">${specsText}</span>
            </div>
        `;

        slotEl.querySelector('.btn-choose-part').textContent = 'Ganti';
        slotEl.querySelector('.btn-clear-part').style.display = 'inline-flex';

        partsModal.classList.remove('active');
        calculateTotals();
    };

    // Clear Part
    const clearPart = (category) => {
        currentBuild[category] = null;

        const detailsEl = document.getElementById(`details-${category.toLowerCase()}`);
        const slotEl = document.getElementById(`slot-${category.toLowerCase()}`);

        detailsEl.innerHTML = '<span class="empty-text">Belum memilih komponen</span>';
        slotEl.querySelector('.btn-choose-part').textContent = 'Pilih';
        slotEl.querySelector('.btn-clear-part').style.display = 'none';

        calculateTotals();
    };

    // Event Listeners
    document.querySelectorAll('.btn-choose-part').forEach(btn => {
        btn.addEventListener('click', function () {
            openModal(this.dataset.category);
        });
    });

    document.querySelectorAll('.btn-clear-part').forEach(btn => {
        btn.addEventListener('click', function () {
            clearPart(this.dataset.category);
        });
    });

    modalSearchInput.addEventListener('input', function () {
        renderModalParts(this.value.trim());
    });

    btnCloseModal.addEventListener('click', function () {
        partsModal.classList.remove('active');
    });

    partsModal.addEventListener('click', function (e) {
        if (e.target === partsModal) {
            partsModal.classList.remove('active');
        }
    });

    // Reset build
    document.getElementById('btn-reset-build').addEventListener('click', function () {
        for (const cat in currentBuild) {
            clearPart(cat);
        }
    });

    // Add build to cart bulk action
    document.getElementById('btn-add-build-to-cart').addEventListener('click', function () {
        const productIds = [];
        for (const cat in currentBuild) {
            if (currentBuild[cat]) {
                productIds.push(currentBuild[cat].id);
            }
        }

        if (productIds.length === 0) {
            if (window.showGlobalToast) {
                window.showGlobalToast('Silakan pilih minimal 1 komponen sebelum memasukkan ke keranjang.', 'error');
            } else {
                alert('Pilih komponen terlebih dahulu');
            }
            return;
        }

        const btn = this;
        const origText = btn.innerHTML;
        btn.innerHTML = '<span>⏳</span> Menambahkan...';
        btn.disabled = true;

        fetch("{{ route('pc-builder.add-to-cart') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_ids: productIds })
        })
        .then(res => {
            if (!res.ok) {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    throw new Error('Unauthorized');
                }
                return res.json().then(data => { throw new Error(data.message || 'Gagal menambahkan'); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Update cart count badge
                const badge = document.getElementById('nav-cart-count');
                if (badge) {
                    badge.textContent = data.cart_count;
                    badge.style.display = 'inline-flex';
                }

                if (window.showGlobalToast) {
                    window.showGlobalToast(data.message, 'success');
                } else {
                    alert(data.message);
                }

                // Redirect to cart after successful bulk addition
                setTimeout(() => {
                    window.location.href = "{{ route('cart.index') }}";
                }, 1000);
            }
        })
        .catch(err => {
            if (err.message !== 'Unauthorized') {
                if (window.showGlobalToast) {
                    window.showGlobalToast(err.message, 'error');
                } else {
                    alert(err.message);
                }
            }
        })
        .finally(() => {
            btn.innerHTML = origText;
            btn.disabled = false;
        });
    });
});
</script>
@endsection
