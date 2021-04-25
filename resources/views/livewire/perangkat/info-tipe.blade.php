<div>
    <div class="px-7 py-3 flex flex-col justify-between h-screen">
        <div x-data="{infoPerangkat: false}">
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold  cursor-default">
                <p class="{{ ($tipeData['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">Info Tipe Perangkat {{ $tipeData['kode_perangkat'] }}</p>
            </div>
           
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    <div class="flex flex-col font-semibold">
                        <table>
                            <tr>
                                <td class="pr-3">Nama perangkat</td>
                                <td>:</td>
                                <td>{{ $tipeData['nama_perangkat'] }}</td>
                            </tr>
                            <tr>
                                <td class="pr-3">Tipe perangkat</td>
                                <td>:</td>
                                <td>{{ $tipeData['tipe_perangkat'] }}</td>
                            </tr>
                            <tr>
                                <td class="pr-3">Total perangkat</td>
                                <td>:</td>
                                <td>{{ $totalPerangkat }}</td>
                            </tr>
                            <tr>
                                <td class="pr-3">Status Tipe Perangkat</td>
                                <td>:</td>
                                <td class="font-semibold capitalize rounded-lg {{ ($tipeData['deleted_at']) ? 'text-red-500' : 'text-blue-500' }}">{{ ($tipeData['deleted_at']) ? 'Terhapus' : 'Aktif' }}</td>
                            </tr>
                        </table>
                    </div>
                    {{-- Search --}}
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari Perangkat..." autocomplete="off">
                            </div>
                        </div>
                </div>
            {{-- End Top Section --}}

            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/12">Tipe</th>
                            <th class="w-1/3">Serial Number</th>
                            <th class="w-1/5">SN Monitor</th>
                            <th class="w-1/5">Witel</th>
                            <th class="w-1/5">User</th>
                            <th class="w-1/5">NO DO</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perangkat as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-gray-300 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($perangkat->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ ($value['id_tipe']) ? $value['TipePerangkat']['kode_perangkat'] : '-' }}</td>
                            <td>{{ $value['sn_pengganti'] }}</td>
                            <td>{{ ($value['sn_monitor']) ? $value['sn_monitor'] : '-' }}</td>
                            @if ($value['id_witel'] != null)
                                <td class="truncate">{{ $value['witel']['nama_witel'] }}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if ($value['id_user'] != null)
                                <td class="truncate">{{ $value['users']['name'] }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ ($value['deliveryOrder']['no_do']) ? $value['deliveryOrder']['no_do'] : '-' }}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">

                                {{-- Lempar event infoPerangkat ke livewire infoPerangkat --}}
                                <button @click="infoPerangkat = true" wire:click="$emit('infoPerangkat', {{ $value['id'] }})" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center pt-5 text-red-500" colspan="9">
                            Data Tidak ditemukan!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- End Table --}}
            <div 
            x-show="infoPerangkat"
            class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start overflow-y-auto">
                <livewire:perangkat.info-perangkat />
            </div>
        </div>
        <div>
            {{-- Pagination --}}
                <div class="mt-2 mx-5">
                    {{ $perangkat->links() }}
                </div>
            {{-- End Pagination --}}
        </div>
    </div>
</div>

    

