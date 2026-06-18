<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail PC: ') }} {{ $pc->nama_pc }}
            </h2>
            <a href="{{ route('katalog.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded border border-gray-400">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Foto -->
                        <div class="flex justify-center items-start">
                            @if($pc->foto)
                                <img src="{{ asset('storage/pcs/' . $pc->foto) }}" alt="Foto {{ $pc->nama_pc }}" class="w-full max-w-md rounded-lg shadow-md object-cover border">
                            @else
                                <div class="w-full max-w-md aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi -->
                        <div>
                            <div class="mb-6">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-3xl font-bold text-gray-900">{{ $pc->nama_pc }}</h3>
                                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $pc->kategori }}</span>
                                </div>
                                <p class="text-gray-500 font-mono">Kode: {{ $pc->kode_pc }}</p>
                            </div>

                            <div class="mb-6">
                                <p class="text-3xl font-bold text-green-600 mb-2">Rp {{ number_format($pc->harga, 0, ',', '.') }}</p>
                                @if($pc->stok > 0 && $pc->tersedia)
                                    <span class="inline-flex items-center text-sm font-medium text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Tersedia (Stok: {{ $pc->stok }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-sm font-medium text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        Stok Habis / Tidak Tersedia
                                    </span>
                                @endif
                            </div>

                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-700 uppercase text-sm tracking-wider">Spesifikasi Detail</h4>
                                </div>
                                <div class="divide-y divide-gray-200 text-sm">
                                    <div class="grid grid-cols-3 px-4 py-3">
                                        <div class="text-gray-500 font-medium">Prosesor</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->prosesor ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3 bg-gray-50">
                                        <div class="text-gray-500 font-medium">VGA</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->vga ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3">
                                        <div class="text-gray-500 font-medium">RAM</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->ram ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3 bg-gray-50">
                                        <div class="text-gray-500 font-medium">Storage</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->storage ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3">
                                        <div class="text-gray-500 font-medium">Motherboard</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->motherboard ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3 bg-gray-50">
                                        <div class="text-gray-500 font-medium">Power Supply</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->psu ?: '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 px-4 py-3">
                                        <div class="text-gray-500 font-medium">Casing</div>
                                        <div class="col-span-2 text-gray-900 font-semibold">{{ $pc->casing ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-sm focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-150 flex justify-center items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
