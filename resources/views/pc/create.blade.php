<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk PC Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- INFORMASI UTAMA -->
                        <h3 class="text-lg font-medium text-blue-600 mb-4 uppercase tracking-wider">Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div>
                                <label for="kode_pc" class="block text-sm font-medium text-gray-700">Kode PC <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_pc" id="kode_pc" value="{{ old('kode_pc') }}" placeholder="cth: NPC-001" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('kode_pc') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="nama_pc" class="block text-sm font-medium text-gray-700">Nama Produk PC <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pc" id="nama_pc" value="{{ old('nama_pc') }}" placeholder="cth: NeroPC Entry Gaming" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('nama_pc') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="ENTRY LEVEL" {{ old('kategori') == 'ENTRY LEVEL' ? 'selected' : '' }}>ENTRY LEVEL</option>
                                    <option value="MID RANGE" {{ old('kategori') == 'MID RANGE' ? 'selected' : '' }}>MID RANGE</option>
                                    <option value="HIGH END" {{ old('kategori') == 'HIGH END' ? 'selected' : '' }}>HIGH END</option>
                                </select>
                                @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- SPESIFIKASI KOMPONEN -->
                        <h3 class="text-lg font-medium text-blue-600 mb-4 uppercase tracking-wider">Spesifikasi Komponen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div>
                                <label for="prosesor" class="block text-sm font-medium text-gray-700">Prosesor <span class="text-red-500">*</span></label>
                                <input type="text" name="prosesor" id="prosesor" value="{{ old('prosesor') }}" placeholder="cth: Intel Core i5-13400F" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('prosesor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="vga" class="block text-sm font-medium text-gray-700">VGA / Kartu Grafis <span class="text-red-500">*</span></label>
                                <input type="text" name="vga" id="vga" value="{{ old('vga') }}" placeholder="cth: NVIDIA RTX 4060" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('vga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="ram" class="block text-sm font-medium text-gray-700">RAM <span class="text-red-500">*</span></label>
                                <input type="text" name="ram" id="ram" value="{{ old('ram') }}" placeholder="cth: 16GB DDR5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('ram') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="storage" class="block text-sm font-medium text-gray-700">Storage <span class="text-red-500">*</span></label>
                                <input type="text" name="storage" id="storage" value="{{ old('storage') }}" placeholder="cth: 512GB NVMe SSD" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('storage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="motherboard" class="block text-sm font-medium text-gray-700">Motherboard <span class="text-red-500">*</span></label>
                                <input type="text" name="motherboard" id="motherboard" value="{{ old('motherboard') }}" placeholder="cth: ASUS B760M-A" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('motherboard') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="psu" class="block text-sm font-medium text-gray-700">Power Supply (PSU) <span class="text-red-500">*</span></label>
                                <input type="text" name="psu" id="psu" value="{{ old('psu') }}" placeholder="cth: Seasonic 650W 80+ Gold" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('psu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="casing" class="block text-sm font-medium text-gray-700">Casing <span class="text-red-500">*</span></label>
                                <input type="text" name="casing" id="casing" value="{{ old('casing') }}" placeholder="cth: NZXT H5 Flow" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('casing') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" placeholder="cth: 8500000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required min="0">
                                @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
                                <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}" placeholder="cth: 10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required min="0">
                                @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- OPSI TAMBAHAN -->
                        <h3 class="text-lg font-medium text-blue-600 mb-4 uppercase tracking-wider">Opsi Tambahan</h3>
                        <div class="space-y-6 mb-8">
                            <div class="flex items-center">
                                <input type="checkbox" name="tersedia" id="tersedia" value="1" {{ old('tersedia', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <label for="tersedia" class="ml-2 block text-sm text-gray-900">Tersedia / Aktif</label>
                                @error('tersedia') <p class="text-red-500 text-xs mt-1 ml-4">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil/Produk (Opsional)</label>
                                <input type="file" name="foto" id="foto" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-gray-400 text-xs mt-1">Maksimal 2MB, format JPG/PNG.</p>
                                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-start space-x-3 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Tambah Produk PC
                            </button>
                            <a href="{{ route('pc.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
