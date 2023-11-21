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

            <input type="file" id="filepond-input" name="buktiPembayaran" required="true" multiple />

            <button type="submit" name="btn-save"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Default</button>
        </form>
    </x-bladewind.card>

    <script src="{{ asset('js/geolocation.js') }}"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('#filepond-input');
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            storeAsFile: true,
            onaddfile: (err, fileItem) => {
                console.log(err, fileItem.getMetadata('resize'));
            },

        });
    </script>
</x-app-layout>
