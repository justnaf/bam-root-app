<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kajian Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="eventHandler()" x-init="init()">
            <div class="w-full px-1 col-span-2">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                    Pilih Kajian
                </label>
                <select x-model="selectedEvent" @change="fetchSessions()" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="status" id="status" required>
                    <option selected>-- Silahkan Pilih Kajian--</option>
                    @foreach ($kajian as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3">Nama Presensi</th>
                                <th class="px-6 py-3">Yang Scan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3">Resume</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="selectedEvent && Array.isArray(presences) && presences.length > 0">
                                <template x-for="item in presences" :key="item.id">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <p x-text="item.presenced_user.data_diri.name"></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.presencer_user.data_diri.name"></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p x-text="item.status"></p>
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
                            <template x-if="!selectedEvent">
                                <tr>
                                    <td colspan="5" class="text-center p-3">Pilih Kegiatan</td>
                                </tr>
                            </template>
                            <template x-if="selectedEvent && Array.isArray(presences) && presences.length === 0">
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
        function eventHandler() {
            return {
                selectedEvent: ''
                , presences: []
                , init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();
                    }
                }
                , fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/presences-majelis/get-data', {
                                method: 'POST'
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                                , body: JSON.stringify({
                                    majelis_id: this.selectedEvent
                                })
                            })
                            .then(response => response.json())
                            .then(response => {
                                this.presences = response.data || [];
                                console.log(this.presences);

                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.presences = [];
                    }
                }
            }

        }

    </script>
    @endpush
</x-app-layout>
