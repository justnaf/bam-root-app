<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                        <h1>Super Admin</h1>
                        <p>{{$roleCounts->dewa}}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                        <h1>Admin</h1>
                        <p>{{$roleCounts->admin}}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                        <h1>Instruktur</h1>
                        <p>{{$roleCounts->instruktur}}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                        <h1>Peserta</h1>
                        <p>{{$roleCounts->peserta}}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('includes.toast')
                    <div class="relative overflow-x-auto">
                        <div x-data="tableComponent()">
                            <div class="flex justify-between mx-auto">
                                <div class="mb-4">
                                    <label for="search" class="mr-2">Search :</label>
                                    <input id="search" type="text" x-model="search" placeholder="NPM/Username" class="px-4 py-2 border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <select id="roleFilter" x-model="selectedRole" class="border rounded py-2 px-6">
                                        <option value="">All Roles</option>
                                        <template x-for="role in allRoles" :key="role">
                                            <option :value="role" x-text="role"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <select id="entriesPerPage" x-model="perPage" class="border rounded py-2 px-6">
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Table -->
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-2 py-3">#</th>
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
                                    <template x-for="(user, index) in paginatedUsers" :key="user.id">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-2 py-3" x-text="index + 1"></th>
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <template x-if="user.data_diri">
                                                    <span x-text="user.data_diri.name"></span>
                                                </template>
                                                <template x-if="!user.data_diri">
                                                    <span>&nbsp;</span>
                                                </template>
                                            </td>
                                            <td class="px-6 py-4" x-text="user.username"></td>
                                            <td class="px-6 py-4">
                                                <template x-if="user.roles && user.roles.length > 0">
                                                    <span x-text="user.roles.join(', ')"></span>
                                                </template>
                                                <template x-if="!user.roles || user.roles.length === 0">
                                                    <span>No Roles</span>
                                                </template>
                                            </td>
                                            <td class="px-6 py-4 flex space-x-2 items-center">
                                                <a :href="'/users/'+ user.id" class="hover:text-green-500">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a :href="'/users/'+ user.id+'/edit/'" class="hover:text-orange-500">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form method="POST" :action="'/users/' + user.id" x-data="deleteForm" x-ref="form">
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
                                    <template x-if="page > 4">
                                        <span class="px-2">...</span>
                                    </template>
                                    <template x-for="pageNumber in pageRange" :key="pageNumber">
                                        <button @click="goToPage(pageNumber)" :class="{'bg-blue-500 text-white': page === pageNumber, 'bg-gray-200': page !== pageNumber}" class="px-4 py-2 rounded-md">
                                            <span x-text="pageNumber"></span>
                                        </button>
                                    </template>
                                    <template x-if="page < totalPages - 3">
                                        <span class="px-2">...</span>
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
                , allRoles: Array.from(new Set(@json($users).flatMap(user => user.roles.map(role => role.name))))
                , search: ''
                , selectedRole: ''
                , page: 1
                , perPage: 20
                , get filteredUsers() {
                    return this.users.filter(user => {
                        const matchesUsername = user.username.toLowerCase().includes(this.search.toLowerCase());
                        const matchesRole = this.selectedRole ? user.roles.includes(this.selectedRole) : true;
                        return matchesUsername && matchesRole;
                    });
                }
                , get paginatedUsers() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredUsers.slice(start, start + this.perPage);
                }
                , get totalPages() {
                    return Math.ceil(this.filteredUsers.length / this.perPage);
                }
                , get pageRange() {
                    const totalPages = this.totalPages;
                    const startPage = Math.max(1, this.page - 3); // Show 3 pages before
                    const endPage = Math.min(totalPages, this.page + 3); // Show 3 pages after
                    return Array.from({
                        length: endPage - startPage + 1
                    }, (_, i) => startPage + i);
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
