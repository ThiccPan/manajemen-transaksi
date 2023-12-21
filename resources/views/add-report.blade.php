<x-app-layout>
    <div
        class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="post" enctype="multipart/form-data" class="signup-form" action="{{ route('report.insert') }}">
            @csrf
            <h1 class="my-2 text-2xl font-light text-gray-900 mb-8">Tambah Laporan transaksi baru</h1>
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe laporan:
            </label>
            <select id="type" name="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4">
                <option value="VISIT">VISIT</option>
                <option value="NOO">NOO</option>
                <option value="ORDER">ORDER</option>
            </select>

            <p id="status"></p>

            <div class="mb-6">
                <label for="clientName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    toko</label>
                <input type="text" id="clientName" name="clientName"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="clientDomicile"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domisili toko</label>
                <input type="text" id="clientDomicile" name="clientDomicile"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <label for="checkInImage">Bukti Check In</label>
            <input type="file" id="checkInImage" name="checkInImage" required="true" />

            <p class="mb-4">
                Lokasi anda saat ini:
                <a id="map-link" target="_blank" class="text-blue-600 visited:text-purple-600"></a>
            </p>

            <input type="hidden" name="coordinate" id="coordinate">

            <button type="submit"
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Unggah
                laporan</button>
        </form>
    </div>

    <script src="{{ asset('js/geolocation.js') }}"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputcheckInImage = document.querySelector('#checkInImage');
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Create a FilePond instance
        const pondcheckInImage = FilePond.create(inputcheckInImage, {
            storeAsFile: true,
            onaddfile: (err, fileItem) => {
                console.log(err, fileItem.getMetadata('resize'));
            },
        });
    </script>
</x-app-layout>
