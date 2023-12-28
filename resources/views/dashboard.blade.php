<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Anda berhasil log in!') }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Laporan terakhir:
                    <p>id: {{ $last_report->id }}</p>
                    <p>toko: {{ $last_report->client_name }}</p>
                    <p>domisili: {{ $last_report->client_domicile }}</p>
                    <p>status: {{ $last_report->status }}</p>
                    <a href="{{ route('report.detail', $last_report->id) }}">detail</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
