<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('events.index')}}">Events Management</a> > <span>Pengajuan Kegiatan</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.toast')
            <a href="{{route('events.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-extrabold text-2xl mb-3">Data Pengajuan Kegiatan Pending</h1>
                    <div x-data="tableComponent()">
                        <div class="flex justify-between mb-4">
                            <div>
                                <input type="text" x-model="search" placeholder="Nama Kegiatan" class="px-4 py-2 border rounded-md w-full">
                            </div>
                            <div class="mb-4">
                                <select id="statusFilter" x-model="selectedStatus" class="border rounded py-2 px-6">
                                    <option value="">All Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submission">Pengajuan</option>
                                    <option value="preparation">Persiapan</option>
                                    <option value="registration">Registrasi</option>
                                    <option value="on-going">Sedang Berlangsung</option>
                                    <option value="done">Selesai</option>
                                </select>
                            </div>
                            <div>
                                <select id="entriesPerPage" x-model="perPage" class="border rounded py-2 px-4">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3">Nama Kegiatan</th>
                                    <th class="px-6 py-3">Mulai</th>
                                    <th class="px-6 py-3">Selesai</th>
                                    <th class="px-6 py-3">Lokasi</th>
                                    <th class="px-6 py-3">Penyelenggara</th>
                                    <th class="px-6 py-3">PIC</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Rows -->
                                <template x-for="events in paginatedEvents" :key="events.id">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4" x-text="events.name" @click="console.log('Start Date:', events)"></td>
                                        <td class="px-6 py-4" x-text="new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(events.start_date))"></td>
                                        <td class="px-6 py-4" x-text="new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(events.end_date))"></td>
                                        <td class="px-6 py-4" x-text="events.location"></td>
                                        <td class="px-6 py-4" x-text="events.institution"></td>
                                        <td class="px-6 py-4" x-text="events.pic || 'Tidak tersedia'"></td>
                                        <td class="px-6 py-4" x-text="events.status"></td>
                                        <td class="px-6 py-4 flex justify-center space-x-2">
                                            <a :href="'/events/' + events.id" class="hover:text-green-600 hover:underline">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <template x-if="events.model_request_event.status == 'pending'">
                                                <div class="flex space-x-2 ">
                                                    <form method="POST" :action="'/events/'+events.model_request_event.id" x-data="approveForm" x-ref="approveform">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" hidden name="status" value="approved">
                                                        <button type="button" class="text-green-600 hover:underline" @click="confirmApprove">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" :action="'/events/'+events.model_request_event.id" x-data="declineForm" x-ref="declineform">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" hidden name="status" value="declined">
                                                        <button type="button" class="text-red-600 hover:underline" @click="confirmDecline">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                </template>

                                <!-- No Data -->
                                <template x-if="filteredEvents.length === 0">
                                    <tr>
                                        <td colspan="8" class="text-center px-6 py-4">Tidak ada data yang tersedia</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>


                        <!-- Pagination -->
                        <div class="mt-4 flex justify-between items-center">
                            <button @click="prevPage" :disabled="page === 1" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Previous</button>
                            <div class="flex space-x-2">
                                <template x-for="pageNumber in Array.from({ length: totalPages }, (_, i) => i + 1)" :key="pageNumber">
                                    <button @click="goToPage(pageNumber)" :class="{'bg-blue-500 text-white': page === pageNumber, 'bg-gray-200': page !== pageNumber}" class="px-4 py-2 rounded-md">
                                        <span x-text="pageNumber"></span>
                                    </button>
                                </template>
                            </div>
                            <button @click="nextPage" :disabled="page === totalPages" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addedScript')
    <script>
        function tableComponent() {
            return {
                events: @json($events), // Data passed from the backend
                search: ''
                , selectedStatus: '', // New property to store the selected status
                page: 1
                , perPage: 5
                , get filteredEvents() {
                    return this.events.filter(event => {
                        const matchesSearch = event.name.toLowerCase().includes(this.search.toLowerCase());
                        const matchesStatus = this.selectedStatus === '' || event.status === this.selectedStatus;
                        return matchesSearch && matchesStatus;
                    });
                }
                , get paginatedEvents() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredEvents.slice(start, start + this.perPage);
                }
                , get totalPages() {
                    return Math.ceil(this.filteredEvents.length / this.perPage);
                }
                , nextPage() {
                    if (this.page < this.totalPages) this.page++;
                }
                , prevPage() {
                    if (this.page > 1) this.page--;
                }
                , goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) this.page = page;
                }


            };
        }

        function approveForm() {
            return {
                confirmApprove() {
                    Swal.fire({
                        title: 'Are you sure?'
                        , text: "Yakin Ingin Menyetujui Kegiatan!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.approveform.submit();
                        }
                    });
                }
            };
        }

        function declineForm() {
            return {
                confirmDecline() {
                    Swal.fire({
                        title: 'Are you sure?'
                        , text: "Yakin Ingin Menolak Kegiatan!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.declineform.submit();
                        }
                    });
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
