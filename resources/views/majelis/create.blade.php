<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('majelis.index')}}">Kajian Management</a> > <span>Tambah</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{route('majelis.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Form Buat Kajian</h1>
                    <form method="POST" action="{{route('majelis.store')}}" class="max-w-lg mx-auto" x-data='eventsForm' x-ref='eForm'>
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Kajian
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="BAM" type="text" name="name" id="name" required />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="category">
                                    Kategori
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="category" id="category" required>
                                    <option value="" disabled selected>-- Silahkan Pilih Kategori --</option>
                                    <option value="Internal">Internal</option>
                                    <option value="Eksternal">Eksternal</option>
                                </select>
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location">
                                    Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Auditorium UNIMMA" type="text" name="location" id="location" required />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Link Gmaps Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="https://" type="text" name="location_url" id="location_url" required />
                            </div>
                            <div class="w-full px-1">
                                <div x-data="{ 
                                    open: false, 
                                    start_date: '', 
                                    timestamp: '', 
                                    formatDateTimeLocal(timestamp) {
                                        // Convert timestamp to 'YYYY-MM-DDTHH:MM' format
                                        if (!timestamp) return '';
                                        const date = new Date(timestamp);
                                        const year = date.getFullYear();
                                        const month = String(date.getMonth() + 1).padStart(2, '0');
                                        const day = String(date.getDate()).padStart(2, '0');
                                        const hours = String(date.getHours()).padStart(2, '0');
                                        const minutes = String(date.getMinutes()).padStart(2, '0');
                                        return `${year}-${month}-${day}T${hours}:${minutes}`;
                                    },
                                    selectDate(event) {
                                        this.timestamp = new Date(event.target.value).getTime();
                                        this.start_date = event.target.value;
                                        this.open = false;
                                    }
                                }" class="relative">
                                    <label for="start_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Mulai
                                    </label>
                                    <input type="text" id="start_date" name="start_date" x-model="start_date" @click="open = true" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" readonly required />

                                    <div x-show="open" @click.away="open = false" class="absolute bg-white border border-gray-300 rounded-md shadow-md mt-1 z-50 p-3">
                                        <input type="datetime-local" @change="selectDate" class="block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-1">
                                <div x-data="{ 
                                    open: false, 
                                    end_date: '', 
                                    timestamp: '', 
                                    formatDateTimeLocal(timestamp) {
                                        if (!timestamp) return '';
                                        const date = new Date(timestamp);
                                        const year = date.getFullYear();
                                        const month = String(date.getMonth() + 1).padStart(2, '0');
                                        const day = String(date.getDate()).padStart(2, '0');
                                        const hours = String(date.getHours()).padStart(2, '0');
                                        const minutes = String(date.getMinutes()).padStart(2, '0');
                                        return `${year}-${month}-${day}T${hours}:${minutes}`;
                                    },
                                    selectDate(event) {
                                        this.timestamp = new Date(event.target.value).getTime(); 
                                        this.end_date = event.target.value;
                                        this.open = false;
                                    }
                                }" class="relative">
                                    <label for="end_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Selesai
                                    </label>

                                    <!-- Input for displaying the selected timestamp -->
                                    <input id="end_date" type="text" name="end_date" x-model="end_date" @click="open = true" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" readonly required />

                                    <!-- Date Picker -->
                                    <div x-show="open" @click.away="open = false" class="absolute bg-white border border-gray-300 rounded-md shadow-md mt-1 z-50 p-3" x-cloak>
                                        <input type="datetime-local" @change="selectDate" class="block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                    </div>
                                </div>

                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="desc">
                                    Deskripsi
                                </label>
                                <textarea class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Apa Ya?" type="number" name="desc" id="desc"></textarea>
                            </div>
                        </div>
                        <div class="px-1">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Simpan</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventsForm() {
            return {
                confirmSimpan() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Sudah Yakin Dengan Data Yang Di Inputkan!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.eForm.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
