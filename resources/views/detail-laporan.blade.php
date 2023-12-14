<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="mx-8 py-12">
        @if ($successMsg = Session::get('success'))
            <x-alert alert-type="success" message="{{ $successMsg }}" />
        @endif

        @if ($errorMsg = Session::get('error'))
            <x-alert alert-type="error" message="{{ $errorMsg }}" />
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">

                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail laporan</h5>
                <p>Dokumen laporan transaksi:</p>
                <p>Tipe Laporan: {{ $laporan->type }}</p>
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

            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                <p>Status: {{ $laporan->status }}</p>
                <p>Waktu check out: {{ $laporan->check_out_at }}</p>
                <form action="{{ route('laporan.update', $laporan->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" href="{{ route('laporan.update', $laporan->id) }}"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                        Change laporan status
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
