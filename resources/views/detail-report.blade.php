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
                <p>Tipe Laporan: {{ $report->type }}</p>
                <p>Sales: {{ $report->user->name }}</p>

                <img src="{{ asset('storage/' . $report->document) }}" alt="dokumen" srcset="">
                Tanggal laporan: {{ $report->created_at }}
            </div>

            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                Lokasi laporan dibuat:
                <a href="{{ $report->coordinate_url }}" target="_blank" class="text-blue-600 visited:text-purple-600">
                    {{ $report->coordinate_url }}
                </a>
                <p>Nama toko: {{ $report->client_name }}</p>
                <p>Domisili toko: {{ $report->client_domicile }}</p>
            </div>

            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                <p>Status: {{ $report->status }}</p>
                @if ($report->type == 'ORDER' && $report->status == 'CHECK_OUT')
                    <p>Waktu check out: {{ $report->check_out_at }}</p>
                    <p>notes: {{ $report->reportOrder->notes }}</p>
                    <p>price: {{ $report->reportOrder->price }}</p>
                @endif
            </div>

            @if ($report->type != 'ORDER')
                <div x-data="{ type: 'VISIT' }"
                    class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                    <form action="{{ route('report.update', $report->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <label for="type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VISIT/NOO</label>
                        <select id="type" name="type" x-model="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4">
                            <option value="VISIT">VISIT</option>
                            <option value="NOO">NOO</option>
                        </select>

                        <button type="submit" href="{{ route('report.update', $report->id) }}"
                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                            check out
                        </button>

                        <template x-if="type == 'NOO'" id="noo_template">
                            <div>
                                <label for="attachment">Bukti Pembayaran</label>
                                <input type="file" id="attachment" name="attachment[]" required="true" multiple />

                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    message</label>
                                <textarea id="message" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write your thoughts here..."></textarea>
                            </div>
                        </template>
                    </form>
                </div>
            @endif

            @if ($report->type == 'ORDER')
                <div
                    class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">
                    <form action="{{ route('report.update', $report->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div
                            class="block p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 my-4">

                            <label for="price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal total
                                pembayaran:</label>
                            <input type="number" id="price" aria-describedby="helper-text-explanation"
                                name="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4"
                                placeholder="Rp." required min="0">

                            <label for="notes"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                message</label>
                            <textarea id="notes" rows="4" name="notes"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4"
                                placeholder="Write your thoughts here..."></textarea>


                            <label for="buktiPembayaran">Bukti Pembayaran</label>
                            <input type="file" id="buktiPembayaran" name="buktiPembayaran[]" required="true"
                                multiple />

                        </div>
                        <button type="submit" href="{{ route('report.update', $report->id) }}"
                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                            check out
                        </button>
                    </form>
                </div>
            @endif

            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
            <script>
                // Get a reference to the file input element
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const inputBuktiPembayaran = document.querySelector('#buktiPembayaran');

                // Create a FilePond instance
                if (inputBuktiPembayaran) {
                    const pondBuktiPembayaran = FilePond.create(inputBuktiPembayaran, {
                        storeAsFile: true,
                        onaddfile: (err, fileItem) => {
                            console.log(err, fileItem.getMetadata('resize'));
                        },
                    });
                }
            </script>
        </div>
    </div>
</x-app-layout>
