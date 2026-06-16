@extends('layouts.app')

@section('title', 'Tambah Produk - Admin NeroPC')

@section('content')
    <section id="form-section" class="form-section">
      <div class="section-header">
        <h2>Tambah Komponen / Paket PC Baru</h2>
      </div>

      @if($errors->any())
          <div class="alert alert-error" style="margin-bottom: 20px;">
              <ul style="margin: 0; padding-left: 16px;">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form id="form-pc" action="{{ route('admin.products.store') }}" method="POST" novalidate>
        @csrf

        <div class="form-section-label">Informasi Utama</div>
        <div class="form-grid form-grid-3">
          <div class="form-group">
            <label for="sku">Kode SKU <span class="required">*</span></label>
            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" placeholder="cth: CPU-INTEL-I5" autocomplete="off" required>
            <span class="error-msg" id="error-sku"></span>
          </div>
          <div class="form-group">
            <label for="name">Nama Produk <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="cth: Intel Core i5-13400F" autocomplete="off" required>
            <span class="error-msg" id="error-name"></span>
          </div>
          <div class="form-group">
            <label for="category">Kategori <span class="required">*</span></label>
            <select id="category" name="category" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Processor" {{ old('category') == 'Processor' ? 'selected' : '' }}>Processor</option>
              <option value="Motherboard" {{ old('category') == 'Motherboard' ? 'selected' : '' }}>Motherboard</option>
              <option value="RAM" {{ old('category') == 'RAM' ? 'selected' : '' }}>RAM</option>
              <option value="VGA" {{ old('category') == 'VGA' ? 'selected' : '' }}>VGA</option>
              <option value="Storage" {{ old('category') == 'Storage' ? 'selected' : '' }}>Storage</option>
              <option value="PSU" {{ old('category') == 'PSU' ? 'selected' : '' }}>PSU</option>
              <option value="Casing" {{ old('category') == 'Casing' ? 'selected' : '' }}>Casing</option>
              <option value="Prebuilt PC" {{ old('category') == 'Prebuilt PC' ? 'selected' : '' }}>Prebuilt PC (Paket Rakitan)</option>
            </select>
            <span class="error-msg" id="error-category"></span>
          </div>
        </div>

        <div class="form-grid form-grid-3">
          <div class="form-group">
            <label for="brand">Merek (Brand) <span class="required">*</span></label>
            <input type="text" id="brand" name="brand" value="{{ old('brand') }}" placeholder="cth: Intel / ASUS / MSI" autocomplete="off" required>
            <span class="error-msg" id="error-brand"></span>
          </div>
          <div class="form-group">
            <label for="price">Harga (Rp) <span class="required">*</span></label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="cth: 2850000" min="0" required>
            <span class="error-msg" id="error-price"></span>
          </div>
          <div class="form-group">
            <label for="stock">Stok <span class="required">*</span></label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" placeholder="cth: 15" min="0" required>
            <span class="error-msg" id="error-stock"></span>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Deskripsi Singkat</label>
          <textarea id="description" name="description" rows="3" placeholder="Tulis deskripsi singkat produk di sini...">{{ old('description') }}</textarea>
        </div>

        <div class="form-options" style="margin: 15px 0;">
            <label class="remember-me">
                <input type="checkbox" name="is_recommended" id="is_recommended" {{ old('is_recommended') ? 'checked' : '' }}>
                <span>Rekomendasikan di Landing Page (Paket PC Rakitan Unggulan)</span>
            </label>
        </div>

        <!-- DYNAMIC SPECIFICATION LIST BUILDER -->
        <div class="form-section-label">Spesifikasi Detail Komponen</div>
        <p class="text-muted" style="font-size: 0.76rem; margin-bottom: 10px;">Tambahkan spesifikasi teknis untuk membantu pengguna membandingkan hardware.</p>
        
        <div class="specs-dynamic-list" id="specs-list-wrapper">
            @if(is_array(old('spec_keys')))
                @foreach(old('spec_keys') as $index => $key)
                    @if(!empty($key))
                        <div class="form-grid form-grid-3 spec-row-dynamic" style="gap: 10px; margin-bottom: 8px;">
                            <input type="text" name="spec_keys[]" value="{{ $key }}" placeholder="cth: Socket" class="spec-input-key" style="padding: 6px 10px; font-size: 0.8rem;">
                            <input type="text" name="spec_vals[]" value="{{ old('spec_vals')[$index] ?? '' }}" placeholder="cth: LGA1700" class="spec-input-val" style="padding: 6px 10px; font-size: 0.8rem;">
                            <button type="button" class="btn-action btn-delete btn-remove-spec-row" style="padding: 6px; justify-content: center;">Hapus</button>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        
        <div style="margin-top: 10px;">
            <button type="button" class="btn-secondary" id="btn-add-spec-row" style="font-size: 0.78rem; padding: 6px 12px;">
                + Tambah Baris Spesifikasi
            </button>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
          <button type="submit" class="btn-primary" id="btn-submit">
             Simpan Produk Baru
          </button>
        </div>
      </form>
    </section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('specs-list-wrapper');
    const btnAddSpec = document.getElementById('btn-add-spec-row');

    const createSpecRow = (key = '', val = '') => {
        const row = document.createElement('div');
        row.className = 'form-grid form-grid-3 spec-row-dynamic';
        row.style.gap = '10px';
        row.style.marginBottom = '8px';
        row.innerHTML = `
            <input type="text" name="spec_keys[]" value="${key}" placeholder="cth: Socket" class="spec-input-key" style="padding: 6px 10px; font-size: 0.8rem;">
            <input type="text" name="spec_vals[]" value="${val}" placeholder="cth: LGA1700" class="spec-input-val" style="padding: 6px 10px; font-size: 0.8rem;">
            <button type="button" class="btn-action btn-delete btn-remove-spec-row" style="padding: 6px; justify-content: center;">Hapus</button>
        `;
        
        row.querySelector('.btn-remove-spec-row').addEventListener('click', function() {
            row.remove();
        });
        
        wrapper.appendChild(row);
    };

    btnAddSpec.addEventListener('click', () => {
        createSpecRow();
    });

    // Attach listener to existing rows if validation failed
    document.querySelectorAll('.btn-remove-spec-row').forEach(btn => {
        btn.addEventListener('click', function() {
            btn.parentElement.remove();
        });
    });
});
</script>
@endsection
