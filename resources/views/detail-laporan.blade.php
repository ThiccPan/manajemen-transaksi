<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="mx-8 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">

                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail laporan</h5>
                <p>Tipe Dokumen:</p>
                <p>Dokumen laporan transaksi:</p>
                <p>Sales: {{ $laporan->user->name }}</p>

                <img src="{{ asset('storage/' . $laporan->dokumen) }}" alt="dokumen" srcset="">
                Tanggal laporan: {{ $laporan->created_at }}
            </div>

            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                Lokasi laporan dibuat:
                <a href="{{ $laporan->url_koordinat }}" target="_blank" class="text-blue-600 visited:text-purple-600">
                    {{ $laporan->url_koordinat }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
