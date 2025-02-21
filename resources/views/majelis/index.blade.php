<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kajian Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{route('majelis.create')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Tambah Kajian</a>
            @include('includes.toast')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3">Nama Kajian</th>
                                <th class="px-6 py-3">Mulai</th>
                                <th class="px-6 py-3">Selesai</th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody x-data="dataTable()">
                            <template x-for="item in filteredData()" :key="item.id">
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p x-text="item.name"></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p x-text="item.start_date"></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p x-text="item.end_date"></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p x-text="item.loc_name"></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form :action="'majelis/'+item.id+'/change-status'" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="border-gray-300 border-2 p-2 rounded-md hover:bg-gray-300 font-bold">
                                                <p x-text="capitalize(item.status)"></p>
                                            </button>
                                        </form>

                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center space-x-2">
                                            <a class="hover:text-green-600 hover:underline" :href="'majelis/'+ item.id">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="hover:text-orange-600 hover:underline" :href="'majelis/'+ item.id +'/edit'">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" :action="'majelis/'+item.id" x-data="deleteForm" x-ref="form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredData().length === 0">
                                <td colspan="6" class="text-center px-6 py-4">Tidak ada data yang tersedia</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function dataTable() {
            return {
                data: @json($kajian)
                , selectedStatus: ''
                , capitalize(text) {
                    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
                }
                , filteredData() {
                    if (this.selectedStatus === '') {
                        return this.data;
                    }
                    return this.data.filter(kajian => kajian.status === this.selectedStatus);
                }
            };
        }

        function deleteForm() {
            return {
                confirmDelete() {
                    Swal.fire({
                        title: 'Are you sure?'
                        , text: "Yakin Ingin Menghapus Data Ini!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes, delete it!'
                        , cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.form.submit();
                        }
                    });
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
