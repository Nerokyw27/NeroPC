<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hubungi Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-300">
                <h2 class="text-2xl font-bold text-white mb-4">Hubungi Kami</h2>
                <p class="max-w-2xl mx-auto mb-8 leading-relaxed">
                    Punya pertanyaan mengenai produk atau butuh bantuan dalam merakit PC Anda? Jangan ragu untuk menghubungi tim support kami melalui kontak di bawah ini.
                </p>
                <div class="flex flex-wrap justify-center gap-8 mt-8">
                    <div class="text-center p-6 bg-gray-800 rounded-lg w-48">
                        <div class="text-4xl mb-3">📧</div>
                        <h3 class="text-lg font-semibold text-white">Email</h3>
                        <p class="text-gray-400">admin@neropc.id</p>
                    </div>
                    <div class="text-center p-6 bg-gray-800 rounded-lg w-48">
                        <div class="text-4xl mb-3">📞</div>
                        <h3 class="text-lg font-semibold text-white">Telepon</h3>
                        <p class="text-gray-400">0812-3456-7890</p>
                    </div>
                    <div class="text-center p-6 bg-gray-800 rounded-lg w-48">
                        <div class="text-4xl mb-3">📍</div>
                        <h3 class="text-lg font-semibold text-white">Alamat</h3>
                        <p class="text-gray-400">Jl. Teknologi Raya No. 88<br>Surabaya, Jawa Timur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        console.log('Halaman Kontak dimuat.');
    </script>
    @endpush
</x-app-layout>
