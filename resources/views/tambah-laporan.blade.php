<x-app-layout>
    <x-bladewind.notification />
    <x-bladewind.card class="mx-8 my-4">
        <form method="post" enctype="multipart/form-data" class="signup-form" action="{{ route('laporan.kirim') }}">
            @csrf
            <h1 class="my-2 text-2xl font-light text-blue-900/80">Tambah Laporan transaksi baru</h1>

            <input type="hidden" name="coordinate" id="coordinate">

            <p>
                Lokasi anda saat ini:
                <a id="map-link" target="_blank" class="text-blue-600 visited:text-purple-600"></a>
            </p>
            
            <p id="status"></p>
            <x-bladewind.filepicker name="buktiPembayaran" required="true" placeholder="Upload bukti pembayaran" />

            <div class="text-center">
                <x-bladewind.button name="btn-save" has_spinner="true" type="primary" color="black" can_submit="true"
                    class="mt-3">
                    Kirim Laporan Transaksi
                </x-bladewind.button>
            </div>
        </form>
    </x-bladewind.card>

    <script src="{{ asset('js/geolocation.js') }}"></script>
</x-app-layout>
