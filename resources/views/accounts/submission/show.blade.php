<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('submission.role.index') }}">Role Submission</a> > <a href="{{ route('submission.role.pending') }}">Role Submission Pending</a> > <span>Show</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('submission.role.pending') }}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <h1 class="font-extrabold text-2xl text-center mb-3">Data Diri</h1>
                        <div class="flex space-x-7 justify-center items-center w-full mb-3">
                            <div class="bg-gray-300 shadow-lg p-4 w-64 h-80 flex items-center justify-center">
                                @if(str_replace(['[', ']', '"'], '', $pendings->user->getRoleNames()) == "SuperAdmin")
                                <p>Dewa Nih Bos</p>
                                @else
                                @if($pendings->user->dataDiri->profile_picture == null)
                                <p>No Picture</p>
                                @else
                                <img src="{{ asset($pendings->user->dataDiri->profile_picture) }}" alt="{{ $pendings->user->dataDiri->name }}" class="w-full h-full object-cover">
                                @endif
                                @endif
                            </div>
                            <div class="p-4">
                                @if(str_replace(['[', ']', '"'], '', $pendings->user->getRoleNames()) == "SuperAdmin")
                                <p>Mau Cari Apa Bos</p>
                                @else
                                <table class="w-full text-left rounded-md">
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">Nama</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md w-60">{{ $pendings->user->dataDiri->name }}</td>
                                    </tr>
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">NPM</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md">{{ $pendings->user->username }}</td>
                                    </tr>
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">Gender</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md">{{ $pendings->user->dataDiri->gender }}</td>
                                    </tr>
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">Tanggal Lahir</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md">{{ $pendings->user->dataDiri->birth_date }}</td>
                                    </tr>
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">Tempat Lahir</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md">{{ $pendings->user->dataDiri->birth_place }}</td>
                                    </tr>
                                    <tr class="border-b-4 border-b-white">
                                        <td class="font-bold bg-gray-500 p-2 rounded-l-md text-center text-white">Alamat</td>
                                        <td class="w-5 font-bold bg-gray-500 text-center text-white">:</td>
                                        <td class="bg-gray-100 px-2 rounded-r-md">{{ $pendings->user->dataDiri->address }}</td>
                                    </tr>
                                </table>
                                @endif
                            </div>
                        </div>
                        <hr class="border-b-1 border-gray-400 my-4 mx-auto max-w-lg mt-5">
                        <h1 class="text-center font-extrabold text-xl mb-1">Alasan Permintaan Request</h1>
                        <p class="text-center">{{$pendings->reason}}</p>
                        <p class="text-center"><span class="font-extrabold text-lg">Requested Role : </span>{{$pendings->requested_role}}</p>
                        <div>
                            <form method="POST" action="{{route('submission.role.approve',['userId' => $pendings->user_id, 'id' => $pendings->id])}}" class="max-w-lg mx-auto text-center" x-data="updateForm" x-ref="updateform">
                                @csrf
                                <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmApprove"><span class="font-extrabold">Approve</span></button>
                            </form>
                            <form method="POST" action="{{route('submission.role.decline',['id' => $pendings->id])}}" class="max-w-lg mx-auto text-center" x-data="declinedForm" x-ref="declineform">
                                @csrf
                                <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" @click="confirmDeclined"><span class="font-extrabold">Declined</span></button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function updateForm() {
            return {
                confirmApprove() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Yakin Approve Pengajuan Ini!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.updateform.submit();
                        }
                    });
                }
            , };
        }

        function declinedForm() {
            return {
                confirmDeclined() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Yakin Menolak Pengajuan Ini!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.declineform.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
