<div>
    <div x-data="{ open: false }">
        <button @click="open = true">Open Dropdown</button>
    
        <ul
            x-show="open"
            @click.away="open = false"
        >
            Dropdown Body
        </ul>
    </div>

    <div class="p-7 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                    <div>
                        <button class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah Data</button>
                    </div>
                    {{-- Search --}}
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-4 mt-2.5 ml-2 opacity-50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        <input class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari user...">
                    </div>
                </div>
            {{-- End Top Section --}}

            {{-- Table --}}
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach ($users as $user)
                            
                        <tr class="text-center items-center">
                            <td>{{ $i }}</td>
                            <td>{{ ($user['nik']) ? $user['nik'] : '-' }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ ($user['no_telp']) ? $user['no_telp'] : '-' }}</td>
                            <td class="space-x-4 pb-1">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-red-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>

                        @php $i++ @endphp
                        @endforeach

                    </tbody>

                </table>
            {{-- End Table --}}
        </div>
        <div>
            {{-- Pagination --}}
                <div class="mt-4 mx-5">
                    {{ $users->links() }}
                </div>
            {{-- End Pagination --}}
        </div>
    </div>

</div>
