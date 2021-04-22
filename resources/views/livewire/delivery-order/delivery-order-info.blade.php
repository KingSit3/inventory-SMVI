<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Info {{ $doData['no_do'] }}</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    <div class="flex flex-col font-semibold">
                        <table>
                            <tr>
                                <td>Tanggal DO</td>
                                <td>:</td>
                                <td>{{ $tanggalDO }}</td>
                            </tr>
                            <tr>
                                <td class="pr-3">Total perangkat</td>
                                <td>:</td>
                                <td>{{ $totalPerangkat }}</td>
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

            {{-- Tambah Perangkat --}}
            @if (session('role') != 2)
                <button @click="isOpen = true" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150 mb-2">Tambah Perangkat</button>
            @endif
            @if ($totalPerangkat > 0)
                <a href="/printdo/{{ $doData['id'] }}" class="bg-yellow-500 hover:shadow-md hover:bg-yellow-600 px-3 py-2 rounded-xl text-white font-semibold duration-150 mb-2">Cetak DO</a>
            @endif
            
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
                            <th class="w-1/12">SP</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perangkat as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
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
                            <td>{{ ($value['sp']) ? $value['sp'] : '-' }}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">

                                <a href="/perangkatinfo/{{ $value['id'] }}" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>

                                @if (session('role') != 2)
                                <button wire:click="$emit('delete', {{ $value['id'] }})" class="focus:outline-none" title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-red-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif

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
        </div>
        <div>
            {{-- Pagination --}}
                <div class="mt-2 mx-5">
                    {{ $perangkat->links() }}
                </div>
            {{-- End Pagination --}}
        </div>

        {{-- modal --}}
            <div 
                x-show="isOpen"
                class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start">
                <div x-show.transition.duration.150ms="isOpen" @click.away="isOpen = false" x-on:click.away="$wire.resetData()" class="w-1/3 mt-10 bg-white opacity-100 rounded-xl shadow-xl">
                    <form wire:submit.prevent="tambah">
                        <div x-data="{cariSn: false}" class="px-8 py-6">
                            <div class="text-center">
                                <span class="text-xl font-semibold capitalize">Tambah Data</span>
                            </div>
                            <div class="mt-4 space-y-1 mr-28 font-semibold">
                                <label for="cariSn" class="cursor-default">Cari Serial Number</label>
                                <div class="relative">
                                    <div wire:loading wire:target="cariSn" class="absolute animate-spin opacity-50 ml-60 mt-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class=" w-5 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input wire:model="cariSn" @focus="cariSn = true" @click.away="cariSn = false" class="inputBox" id="cariSn" type="text" autocomplete="off">
                                @error('cariSn')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (strlen($snResult) > 0)
                                <div x-show="cariSn">
                                    <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                        @if ($snResult)
                                            @forelse ($snResult as $value)
                                                <button @click="cariSn = false" wire:click="chooseSn({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{ $value['tipe_perangkat'] }} | {{  $value['sn_pengganti'] }}</li></button>
                                            @empty
                                                <span class="text-sm font-normal"> Data User tidak ditemukan!</span>
                                            @endforelse
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            <div class="flex justify-between space-x-3">
                                <div class="mt-4 font-semibold">
                                    <label for="serialNumber">Serial Number</label>
                                    <input wire:model="sn" id="serialNumber" class="inputBox"  type="text" disabled>
                                </div>
                                <div class="mt-4 font-semibold">
                                    <label for="witel">Witel</label>
                                    <input wire:model="witel" id="witel" class="inputBox"  type="text" disabled>
                                </div>
                            </div>
                            <div class="flex justify-between space-x-3">
                                <div class="mt-4 font-semibold">
                                    <label for="tipe">Tipe Perangkat</label>
                                    <input wire:model="tipe" id="tipe" class="inputBox"  type="text" disabled>
                                </div>
                                <div class="mt-4 font-semibold">
                                    <label for="image">Image</label>
                                    <input wire:model="image" id="image" class="inputBox"  type="text" disabled>
                                </div>
                            </div>

                        </div>
                        <div class="border-t-2 border-gray-200 mt-5">
                            <div class="flex justify-end space-x-8 p-3">
                            {{-- Type button agar tidak dianggap submit ama livewire --}}
                            <button type="button" @click="isOpen = false" x-on:click="$wire.resetData()" class="text-red-500 font-semibold focus:outline-none">Close</button>
                            <button type="submit" class="bg-blue-500 font-semibold text-white px-4 py-2 rounded-xl hover:bg-blue-700 duration-200 focus:outline-none">tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        {{-- End Modal --}}

    </div>

    {{-- Push Script To Template --}}
    @push('script')
        <script>
            document.addEventListener('livewire:load', function () {
            @this.on('delete', id => {
                // Jalankan sweet alert
                Swal.fire({
                title: 'Yakin ingin menghapusnya?',
                // text: "User ".name." akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil method livewire
                    @this.call('delete', id)
                    // Pesan berhasil
                    Swal.fire(
                    'Deleted!',
                    'Data berhasil dihapus',
                    'success'
                    )
                }
                })
            })
        })

            document.addEventListener('livewire:load', function () {
                @this.on('success', message => {
                    Swal.fire({
                    icon: 'success',
                    title: "Berhasil",
                    text: message,
                    showConfirmButton: false,
                    timer: 1500
                        })
                    })
            })
        </script>
    @endpush
</div>

    

