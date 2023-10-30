<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="mx-8 py-12">
        <x-bladewind.table>
            <x-slot name="header">
                <th>ID</th>
                <th>Lokasi mitra</th>
                <th>Dokumen</th>
            </x-slot>
            @foreach ($daftar_laporan as $laporan)
                <tr>
                    <td>{{ $laporan->id }}</td>
                    <td>
                        <a href="{{ $laporan->url_koordinat }}" target="_blank"
                            class="text-blue-600 visited:text-purple-600">
                            Link
                        </a>
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $laporan->dokumen) }}" target="_blank"
                            class="text-blue-600 visited:text-purple-600">
                            Link
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-bladewind.table>
    </div>
</x-app-layout>
