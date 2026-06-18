<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail PC: ') }} {{ $pc->nama_pc }}
            </h2>
            <a href="{{ route('pc.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded border border-gray-400">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Foto -->
                        <div class="flex justify-center items-start">
                            @if($pc->foto)
                                <img src="{{ asset('storage/pcs/' . $pc->foto) }}" alt="Foto {{ $pc->nama_pc }}" class="w-full max-w-sm rounded-lg shadow-md object-cover">
                            @else
                                <div class="w-full max-w-sm aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi -->
                        <div>
                            <div class="mb-6">
                                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $pc->nama_pc }}</h3>
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $pc->kategori }}</span>
                                
                                @if($pc->tersedia)
                                    <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full ml-2">Tersedia</span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-800 text-sm font-semibold px-3 py-1 rounded-full ml-2">Tidak Tersedia</span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Harga</p>
                                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pc->harga, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Stok Tersedia</p>
                                    <p class="text-lg text-gray-800">{{ $pc->stok }} Unit</p>
                                </div>

                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Ditambahkan Pada</p>
                                    <p class="text-lg text-gray-800">{{ $pc->created_at->format('d M Y H:i') }}</p>
                                </div>
                                
                                <div class="border-b pb-4">
                                    <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Terakhir Diperbarui</p>
                                    <p class="text-lg text-gray-800">{{ $pc->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="mt-8 flex space-x-3">
                                <a href="{{ route('pc.edit', $pc->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-center transition duration-150">
                                    Edit Produk
                                </a>
                                
                                <form action="{{ route('pc.destroy', $pc->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                        Hapus Produk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
