<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role Submission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.toast')
            <a href="{{route('submission.role.pending')}}" class="text-orange-700 hover:text-white border border-orange-700 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Lihat Submission Pending</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div x-data="tableComponent()">
                        <!-- Search and Entries Per Page -->
                        <div class="flex justify-between mb-4">
                            <div>
                                <input type="text" x-model="search" placeholder="Search by NPM/Username" class="px-4 py-2 border rounded-md w-full">
                            </div>
                            <div>
                                <label for="entriesPerPage" class="mr-2">Entries per page:</label>
                                <select id="entriesPerPage" x-model="perPage" class="border rounded py-2 px-4">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3">Nama Lengkap</th>
                                    <th class="px-6 py-3">NPM / Username</th>
                                    <th class="px-6 py-3">Reason</th>
                                    <th class="px-6 py-3">Requested Role</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- No Data -->
                                <template x-if="filteredUsers.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center px-6 py-4">No Data Display</td>
                                    </tr>
                                </template>

                                <!-- Data Rows -->
                                <template x-for="request in paginatedUsers" :key="request.id">
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div x-data="{ date: request.created_at }">
                                                <!-- Formatkan tanggal saja -->
                                                <p x-text="new Date(date).toISOString().split('T')[0]"></p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4" x-text="request.user.data_diri ? request.user.data_diri.name : 'N/A'"></td>
                                        <td class="px-6 py-4" x-text="request.user.username"></td>
                                        <td class="px-6 py-4" x-text="request.reason || 'N/A'"></td>
                                        <td class="px-6 py-4">
                                            <template x-if="request.user.roles && request.user.roles.length > 0">
                                                <span x-text="request.requested_role"></span>
                                            </template>
                                            <template x-if="!request.user.roles || request.user.roles.length === 0">
                                                <span>No Roles</span>
                                            </template>
                                        </td>
                                        <template x-if="request.status == 'pending'">
                                            <td class="px-6 py-4 flex space-x-2">
                                                <a :href="'/submission-role/' + request.id" class="hover:text-green-500">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form method="POST" :action="'/submission-role/' + request.user_id+'/'+request.id" x-data="approveForm" x-ref="form">
                                                    @csrf
                                                    <button type="button" class="hover:text-red-500" @click="confirmApprove">
                                                        <i class="fas fa-check-square"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </template>
                                        <template x-if="request.status != 'pending'">
                                            <td class="px-6 py-4 ">
                                                <div x-data="{ status: request.status }" class="ml-0">
                                                    <p x-text="status.charAt(0).toUpperCase() + status.slice(1)"></p>
                                                </div>
                                            </td>
                                        </template>
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
                requests: @json($alls)
                , search: ''
                , page: 1
                , perPage: 5
                , get filteredUsers() {
                    return this.requests.filter(request =>
                        (request.user.username && request.user.username.toLowerCase().includes(this.search.toLowerCase())) ||
                        (request.user.data_diri && request.user.data_diri.name.toLowerCase().includes(this.search.toLowerCase()))
                    );
                }
                , get paginatedUsers() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredUsers.slice(start, start + this.perPage);
                }
                , get totalPages() {
                    return Math.ceil(this.filteredUsers.length / this.perPage);
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
            }
        }

        function approveForm() {
            return {
                confirmApprove() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Yakin Ingin Langsung Approve!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.form.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
