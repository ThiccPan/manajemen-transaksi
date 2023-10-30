<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="mx-8 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-bladewind.card title="Detail laporan">
                Dokumen laporan transaksi
                <x-bladewind.list-item>
                    <img src="{{ asset('storage/' . $laporan->dokumen) }}" alt="dokumen" srcset="">
                </x-bladewind.list-item>
            </x-bladewind.card>

            <x-bladewind.card>
                Lokasi laporan:
                <a href="{{ $laporan->url_koordinat }}" target="_blank" class="text-blue-600 visited:text-purple-600">
                    {{ $laporan->url_koordinat }}
                </a>
            </x-bladewind.card>
        </div>
    </div>
</x-app-layout>