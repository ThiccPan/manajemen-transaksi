<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Kirim Transaksi</title>

    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
</head>

<body>
    <x-bladewind.notification />
    <x-bladewind.card>
        <form method="post" enctype="multipart/form-data" class="signup-form" action="{{ route('laporan.kirim') }}">
            @csrf
            <h1 class="my-2 text-2xl font-light text-blue-900/80">Tambah Laporan transaksi baru</h1>

            <input type="hidden" name="coordinate" id="coordinate">
            <a id="map-link" target="_blank"></a>

            <x-bladewind.filepicker name="buktiPembayaran" required="true" placeholder="Upload bukti pembayaran" />

            <div class="text-center">
                <x-bladewind.button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
                    Kirim Laporan Transaksi
                </x-bladewind.button>
            </div>

        </form>
    </x-bladewind.card>

    <p id="status"></p>
    <script src="{{ asset('js/geolocation.js') }}"></script>
</body>

</html>
