<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tentang Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-300">
                <h2 class="text-2xl font-bold text-white mb-4">Tentang NeroPC</h2>
                <p class="max-w-2xl mx-auto mb-8 leading-relaxed">
                    NeroPC adalah sistem informasi penjualan PC rakitan terkemuka yang dirancang untuk memberikan kemudahan bagi pelanggan dalam memilih dan merakit PC impian mereka. Kami menyediakan komponen terbaik dengan harga bersaing, serta layanan perakitan yang profesional.
                </p>
                <div class="flex justify-center gap-6 mt-8">
                    <div class="p-6 bg-gray-800 rounded-lg w-64 text-center">
                        <h3 class="text-xl text-blue-500 mb-2 font-semibold">Visi</h3>
                        <p class="text-sm">Menjadi penyedia layanan perakitan PC nomor satu di Indonesia.</p>
                    </div>
                    <div class="p-6 bg-gray-800 rounded-lg w-64 text-center">
                        <h3 class="text-xl text-blue-500 mb-2 font-semibold">Misi</h3>
                        <p class="text-sm">Memberikan kualitas, kecepatan, dan kepuasan maksimal kepada setiap pelanggan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        console.log('Halaman Tentang Kami dimuat.');
    </script>
    @endpush
</x-app-layout>
