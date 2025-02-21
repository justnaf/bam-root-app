<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('majelis.index')}}">Kajian Management</a> > <span>Show</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{route('majelis.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Detail Kajian</h1>
                    <div class="max-w-lg mx-auto">
                        <p class="flex justify-center mb-3">
                            {!! QrCode::size(256)->generate($majeli->code) !!}
                        </p>
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Kajian
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" value="{{$majeli->name}}" type="text" name="name" id="name" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="institution">
                                    Kategori
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" value="{{$majeli->category}}" type="text" name="category" id="category" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location">
                                    Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Auditorium UNIMMA" value="{{$majeli->loc_name}}" type="text" name="location" id="location" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Link Gmaps Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="https://" type="text" name="location_url" id="location_url" disabled value="{{$majeli->loc_link}}" />
                            </div>
                            <div class="w-full px-1">
                                <label for="start_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    Mulai
                                </label>
                                <input type="text" id="start_date" name="start_date" value="{{$majeli->start_date}}" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label for="end_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    Selesai
                                </label>

                                <!-- Input for displaying the selected timestamp -->
                                <input id="end_date" type="text" name="end_date" value="{{$majeli->end_date}}" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" value="{{$majeli->end_date}}" disabled />
                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="desc">
                                    Deskripsi
                                </label>
                                <textarea class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Apa Ya?" type="number" name="desc" id="desc" disabled>{{$majeli->desc}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
