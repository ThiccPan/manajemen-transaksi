<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="mx-8 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-12">
                <x-bladewind::button icon="plus" button_text_css="font-bold" radius="small" tag="a"
                    href="{{ route('laporan.tambah') }}">Tambah Laporan</x-bladewind::button>
            </div>
            <x-bladewind.table>
                <x-slot name="header">
                    <th>ID</th>
                    <th>Sales</th>
                    <th>Lokasi mitra</th>
                    <th>Dokumen</th>
                    <th>Tanggal dibuat</th>
                    <th>Ubah</th>
                </x-slot>
                @foreach ($daftar_laporan as $laporan)
                    <tr>
                        <td>{{ $laporan->id }}</td>
                        <td>{{ $laporan->user->name }}</td>
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
                        <td>
                            {{ $laporan->created_at }}
                        </td>
                        <td>
                            <div class="flex flex-row">
                                <form action="{{ route('laporan.detail', ['id' => $laporan->id]) }}" method="get">
                                    <x-bladewind.button size="tiny" radius="small" can_submit="true" color="blue">
                                        ubah
                                    </x-bladewind.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-bladewind.table>
        </div>
    </div>
</x-app-layout>
