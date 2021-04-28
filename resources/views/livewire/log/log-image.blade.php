<div>
    <div x-data="{detailLog: false}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Log Image Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
            <div class="flex justify-end px-5 mb-5">
                <div class="flex justify-between items-center space-x-6">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-4 mt-2.5 ml-2 opacity-50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        {{-- Search Loading Animation --}}
                        <div wire:loading wire:target="keyword" class="absolute ml-52 mt-2 animate-spin opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class=" w-4 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                            </svg>
                        </div>
                        <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari Image...">
                    </div>
                </div>
            </div>
            {{-- End Top Section --}}

            {{-- Table --}}
                <table class="table-fixed w-full mt-5">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">Kode Image</th>
                            <th class="w-1/6">Perubahan</th>
                            <th class="w-1/6">Oleh</th>
                            <th class="w-1/6">Tanggal Log</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logImage as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($logImage->firstItem()-1) + $loop->iteration }}</td>
                            <td><a class="hover:text-blue-500 duration-200 font-semibold" href="/logimage/{{ $value['id_image'] }}">{{ $value['image']['kode_image']}}</a></td>
                            <td class="capitalize">{{ $value['data_log']['aksi']}} Data</td>
                            <td class="capitalize">{{ $value['data_log']['edited_by']}}</td>
                            <td>{{ $value['tanggal'] }}</td>

                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <button @click="detailLog = true" wire:click="$emit('detailLogImage', {{ $value['id'] }})" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center pt-5 text-red-500" colspan="6">
                            Data Tidak ditemukan!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- End Table --}}
            <div 
            x-show="detailLog"
            class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start overflow-y-auto">
                <livewire:log.detail.detail-image />
            </div>
        </div>
        <div>
            {{-- Pagination --}}
                <div class="mt-2 mx-5">
                    {{ $logImage->links() }}
                </div>
            {{-- End Pagination --}}
        </div>
    </div>
</div>

    

