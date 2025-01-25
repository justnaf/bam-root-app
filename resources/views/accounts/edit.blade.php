<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('users.index')}}">User Management</a> > <span>Edit</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{route('users.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto content-center">
                        <h1 class="text-center font-extrabold text-xl mb-3">Data Diri</h1>
                        @if(str_replace(['[', ']', '"'], '', $user->getRoleNames()) == "SuperAdmin")
                        <p class="text-center">Dewa Nih Bos</p>
                        @else
                        <div class="bg-gray-300 p-4 w-64 h-80 flex items-center justify-center mx-auto mb-5">
                            @if($user->dataDiri->profile_picture == null)
                            <p>No Picture</p>
                            @else
                            <img src="{{url('https://peserta.siaruna.com/storage/'.$user->dataDiri->profile_picture)}}" alt="{{$user->dataDiri->name}}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="max-w-lg mx-auto">
                            <div class="grid grid-cols-2 grid-flow-row gap-4 max-w-lg mx-auto mb-3">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                        Nama Lengkap
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="name" id="name" type="text" value="{{$user->dataDiri->name}}" disabled>
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                        Gender
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="gender" id="gender" type="text" value="{{$user->dataDiri->gender}}" disabled>
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="birth_date">
                                        Tanngal Lahir
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="birth_date" id="birth_date" type="text" value="{{$user->dataDiri->birth_date}}" disabled>
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="birt_place">
                                        Tempat Lahir
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="birt_place" id="birt_place" type="text" value="{{$user->dataDiri->birth_place}}" disabled>
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0 col-span-2">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone_number">
                                        Nomor Telpon
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="phone_number" id="phone_number" type="text" value="{{$user->dataDiri->phone_number}}" disabled>
                                </div>
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="address">
                                    Alamat
                                </label>
                                <textarea class="resize-none h-32 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:border-gray-200 " name="address" id="address" type="text" disabled>{{$user->dataDiri->address}}</textarea>
                            </div>
                        </div>
                        @endif
                        <hr class="border-b-1 border-gray-400 my-4 mx-auto max-w-lg">
                        <h1 class="text-center font-extrabold text-xl mb-3">Data Login</h1>
                        <form method="POST" action="{{route('users.update',$user->id)}}" class="max-w-lg mx-auto mb-4" x-data="updateForm" x-ref="updateform">
                            @csrf
                            @method('PUT')
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="username">
                                    NPM / Username
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="username" id="username" type="text" value="{{$user->username}}">
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                                    Email
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="email" id="email" type="email" value="{{$user->email}}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="role">
                                    Role
                                </label>
                                <div class="relative mb-3">
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="role" id="role">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->getRoleNames()->contains($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                                    Password
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="password" id="password" type="password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password_confirmation">
                                    Re-Type Password
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="password_confirmation" id="password_confirmation" type="password">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="px-3">
                                <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmUpdate"><span class="font-extrabold">Update</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function updateForm() {
            return {
                confirmUpdate() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Pastikan Password Disimpan Dengan Baik Jika Mengganti!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes, Change'
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

    </script>
    @endpush
</x-app-layout>
