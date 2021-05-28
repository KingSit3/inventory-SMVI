<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Delivery Order Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                        <div>
                        @if (session('role') != 2)
                            <button @click="isOpen = true" wire:click="add" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah DO</button>
                        @endif
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari DO...">
                            </div>
                        </div>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">Delivery Order</th>
                            <th class="w-1/6">Witel</th>
                            <th class="w-1/6">Tanggal Do</th>
                            @if (session('role') != 2)
                            <th class="w-1/5">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengiriman as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($pengiriman->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ $value['no_pengiriman'] }}</td>
                            <td>{{ ($value['cabang']['nama_cabang']) ? $value['cabang']['nama_cabang'] : '-' }}</td>
                            <td>{{ ($value['tanggalPengiriman']) ? $value['tanggalPengiriman'] : '-' }}</td>

                            <td class="space-x-4 py-1 flex items-center justify-center">
                            <a href="/pengiriman/{{ $value['id'] }}" class="focus:outline-none" title="Info Delivery Order">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>

                            @if (session('role') != 2)
                            
                                <button @click="isOpen = true" wire:click="edit({{ $value['id'] }})" class="focus:outline-none" title="Edit Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                
                                <button wire:click="$emit('delete', {{ $value['id'] }})" class="focus:outline-none" title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-red-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                            @endif

                        </tr>
                        @empty
                        <tr>
                            <td class="text-center pt-5 text-red-500" colspan="5">
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
                    {{ $pengiriman->links() }}
                </div>
            {{-- End Pagination --}}
        </div>

        {{-- modal --}}
            <div 
                x-show="isOpen"
                class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start">
                <div x-show.transition.duration.150ms="isOpen" class="w-1/3 mt-10 bg-white opacity-100 rounded-xl shadow-xl">
                    <form wire:submit.prevent="{{ $submitType }}">
                        <div class="px-8 py-6">
                            <div class="text-center">
                                <span class="text-xl font-semibold capitalize">{{ $submitType }} Data</span>
                            </div>
                            <div class="mt-4 space-y-1 mx-10 font-semibold">
                                <label for="no_pengiriman" class="cursor-default">Nomor Delivery Order</label>
                                <input wire:model.defer="no_pengiriman" id="no_pengiriman" class="inputBox"  type="text" required autocomplete="off">
                                <p class="text-xs opacity-50 capitalize">*Berdasarkan DO terakhir + 1</p>
                                @error('no_pengiriman')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-4 space-y-1 mx-10 font-semibold">
                                <label for="tanggal" class="cursor-default">Tanggal Delivery Order</label>
                                <input wire:model.defer="tanggal" id="tanggal" class="inputBox" type="date" autocomplete="off">
                                <p class="text-xs opacity-50 capitalize">*Kosongkan Jika hari ini</p>
                                @error('tanggal')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Witel --}}
                            <div  x-data="{cabangSearch: false}"  class="mt-4 space-y-1 mx-10 font-semibold">
                                    <label for="cabang" class="cursor-default pt-2">Cabang</label>
                                    <div class="flex">
                                        <input wire:model="cabangSearch" @focus="cabangSearch = true" @click.away="cabangSearch = false" class="inputBox" id="cabang" type="text" placeholder="Cari Cabang" autocomplete="off">
                                        <div wire:loading wire:target="cabangSearch" class="absolute animate-spin opacity-50 ml-72 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" w-4 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('cabang')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                    @enderror
                                    @if (strlen($cabangSearch) > 0)
                                        <div x-show="cabangSearch">
                                            <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                                @if ($cabangResult)
                                                    @forelse ($cabangResult as $value)
                                                        <button @click="cabangSearch = false" wire:click="chooseCabang({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{  $value['kode_cabang'].' | '.$value['nama_cabang'] }}</li></button>
                                                    @empty
                                                        <span class="text-sm font-normal"> Data Witel tidak ditemukan!</span>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="">
                                    <input wire:model.defer="cabang" class="inputBox mt-3" type="text" disabled autocomplete="off">
                                    </div>
                            </div>
                            {{-- End Witel --}}

                        </div>
                        <div class="border-t-2 border-gray-200 mt-5">
                            <div class="flex justify-end space-x-8 p-3">
                            {{-- Type button agar tidak dianggap submit ama livewire --}}
                            <button type="button" @click="isOpen = false" x-on:click="$wire.resetData()" class="text-red-500 font-semibold focus:outline-none" title="Tutup">Close</button>
                            <button type="submit" class="bg-blue-500 font-semibold text-white px-4 py-2 rounded-xl hover:bg-blue-700 duration-200 focus:outline-none" title="Simpan">Simpan</button>
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

    

