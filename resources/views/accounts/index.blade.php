<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('includes.toast')
                    <div class="relative overflow-x-auto">
                        <div x-data="tableComponent()">
                            <div class=" flex justify-between mx-auto">
                                <div class="mb-4 ">
                                    <input type="text" x-model="search" placeholder="NPM/Username" class="px-4 py-2 border rounded-md w-full">
                                </div>
                                <div class="mb-4">
                                    <label for="entriesPerPage" class="mr-2">Entries per page:</label>
                                    <select id="entriesPerPage" x-model="perPage" class="border rounded py-2 px-6">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Table -->
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                                        <th scope="col" class="px-6 py-3">NPM / Username</th>
                                        <th scope="col" class="px-6 py-3">Roles</th>
                                        <th scope="col" class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="filteredUsers.length === 0">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th colspan="4" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">No Data Display</th>
                                        </tr>
                                    </template>
                                    <template x-for="user in paginatedUsers" :key="user.id">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <template x-if="user.data_diri">
                                                    <span x-text="user.data_diri.name"></span>
                                                </template>
                                                <template x-if="!user.data_diri">
                                                    <span>&nbsp;</span>
                                                </template>
                                            </th>
                                            <td class="px-6 py-4" x-text="user.username"></td>
                                            <td class="px-6 py-4">
                                                <template x-if="user.roles && user.roles.length > 0">
                                                    <span x-text="user.roles.join(', ')"></span> <!-- Join the roles into a comma-separated string -->
                                                </template>
                                                <template x-if="!user.roles || user.roles.length === 0">
                                                    <span>No Roles</span>
                                                </template>
                                            </td>
                                            <td class="px-6 py-4 flex space-x-2 items-center">
                                                <a :href="'/user/'+ user.id" class="hover:text-green-500">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a :href="'/user/'+ user.id+'/edit/'" class="hover:text-orange-500">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form method="POST" :action="'/user/destroy/' + user.id" x-data="deleteForm" x-ref="form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
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
    </div>
    @push('addedScript')
    <script>
        function tableComponent() {
            return {
                users: @json($users).map(user => ({
                    ...user
                    , roles: user.roles.map(role => role.name), // Ensure roles are an array of role names
                }))
                , search: ''
                , page: 1
                , perPage: 5
                , get filteredUsers() {
                    return this.users.filter(user => user.username.toLowerCase().includes(this.search.toLowerCase()));
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
