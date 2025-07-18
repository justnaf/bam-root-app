<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Presensi Kajian') }} > {{$user->dataDiri->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3">No.</th>
                                <th class="px-6 py-3">Nama Presensi</th>
                                <th class="px-6 py-3">Yang Scan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Bukti Foto</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3">Resume</th>
                            </tr>
                        </thead>
                        <tbody x-data="dataTable()" x-init="init()">
                            <template x-if="Array.isArray(presences) && presences.length > 0">
                                <template x-for="(item, index) in presences" :key="item.id">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4" x-text="index + 1"></td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.presenced_user.data_diri.name"></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <template x-if="item.user_id_presencer ">
                                                <p x-text="item.presencer_user.data_diri.name"></p>
                                            </template>
                                            <template x-if="!item.user_id_presencer ">
                                                <p x-text="item.user_id_presencer ?? 'Kajian Eksternal'"></p>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.status"></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <template x-if="!item.proof_pic">
                                                <p>Tidak Ada Foto</p>
                                            </template>
                                            <template x-if="item.proof_pic">
                                                <p x-text="item.proof_pic"></p>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.desc"></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.resume ?? 'Belum Mengisi resume'"></p>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="Array.isArray(presences) && presences.length === 0">
                                <tr>
                                    <td colspan="5" class="text-center p-3">Tidak ada data</td>
                                </tr>
                            </template>
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
                presences: @json($data)
                , init() {
                    console.log(this.presences);
                }

            }
        }

    </script>
    @endpush
</x-app-layout>
