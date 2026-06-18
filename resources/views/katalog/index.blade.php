<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Produk PC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($pcs as $pc)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow">
                        @if($pc->foto)
                            <img src="{{ asset('storage/pcs/' . $pc->foto) }}" alt="{{ $pc->nama_pc }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900 truncate" title="{{ $pc->nama_pc }}">{{ $pc->nama_pc }}</h3>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $pc->kategori }}</span>
                            </div>
                            
                            <div class="text-xs text-gray-600 mb-4 space-y-1">
                                <p><span class="font-semibold">CPU:</span> {{ Str::limit($pc->prosesor, 20) }}</p>
                                <p><span class="font-semibold">VGA:</span> {{ Str::limit($pc->vga, 20) }}</p>
                                <p><span class="font-semibold">RAM:</span> {{ $pc->ram }}</p>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <span class="text-lg font-bold text-green-600">Rp {{ number_format($pc->harga, 0, ',', '.') }}</span>
                                <a href="{{ route('katalog.show', $pc->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 text-center rounded-lg shadow-sm border border-gray-200">
                        <p class="text-gray-500">Belum ada produk PC di katalog.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $pcs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
