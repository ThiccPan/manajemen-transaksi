<x-app-layout>
    <div
        class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="post" enctype="multipart/form-data" class="signup-form" action="{{ route('report.insert') }}">
            @csrf
            <h1 class="my-2 text-2xl font-light text-gray-900">Tambah Laporan transaksi baru</h1>

            <input type="hidden" name="coordinate" id="coordinate">


            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                option</label>
            <select id="type" name="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4">
                <option value="VISIT">VISIT</option>
                <option value="NOO">NOO</option>
                <option value="ORDER">ORDER</option>
            </select>

            <p id="status"></p>

            <label for="buktiCheckIn">Bukti Check In</label>
            <input type="file" id="buktiCheckIn" name="buktiCheckIn" required="true" />

            <label for="buktiPembayaran">Bukti Pembayaran</label>
            <input type="file" id="buktiPembayaran" name="buktiPembayaran[]" required="true" multiple />

            <p class="mb-4">
                Lokasi anda saat ini:
                <a id="map-link" target="_blank" class="text-blue-600 visited:text-purple-600"></a>
            </p>

            <button type="submit" name="btn-save"
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Unggah
                laporan</button>
        </form>
    </div>

    <script src="{{ asset('js/geolocation.js') }}"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputBuktiPembayaran = document.querySelector('#buktiPembayaran');
        const inputBuktiCheckIn = document.querySelector('#buktiCheckIn');
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Create a FilePond instance
        const pondBuktiPembayaran = FilePond.create(inputBuktiPembayaran, {
            storeAsFile: true,
            onaddfile: (err, fileItem) => {
                console.log(err, fileItem.getMetadata('resize'));
            },
        });

        const pondBuktiCheckIn = FilePond.create(inputBuktiCheckIn, {
            storeAsFile: true,
            onaddfile: (err, fileItem) => {
                console.log(err, fileItem.getMetadata('resize'));
            },
        });

        const checkInPond = FilePond.create();
    </script>
</x-app-layout>
