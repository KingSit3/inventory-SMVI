<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Cabang Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                    <div>
                        @if (session('role') != 2)
                        <button @click="isOpen = true" wire:click="add" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah Cabang</button>
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari Cabang">
                            </div>
                        </div>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/3">Kode Cabang</th>
                            <th class="w-1/6">Nama Cabang</th>
                            <th class="w-1/3">PIC</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cabang as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($cabang->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ ($value['kode_cabang']) ? $value['kode_cabang'] : '-' }}</td>
                            <td class="truncate capitalize">{{ $value['nama_cabang'] }}</td>
                            <td>{{ ($value['users']['nama']) ? $value['users']['nama'] : '-' }}</td>

                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <a href="/cabang/{{ $value['id'] }}" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                                @if (session('role') != 2)
                                <button @click="isOpen = true" wire:click="edit({{ $value['id'] }})" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                </button>

                                <button wire:click="$emit('delete', {{ $value['id'] }})" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-red-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </td>

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
                    {{ $cabang->links() }}
                </div>
            {{-- End Pagination --}}
        </div>

        {{-- modal --}}
            <div
                x-show="isOpen"
                class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start">
                <div x-show.transition.duration.150ms="isOpen" class="w-2/5 mt-10 bg-white opacity-100 rounded-xl shadow-xl">
                    <form wire:submit.prevent="{{ $submitType }}">
                        <div class="px-8 py-6">
                            <div class="text-center">
                                <span class="text-xl font-semibold capitalize">{{ $submitType }} Data</span>
                            </div>
                            <div class="mt-4 space-y-1 mx-10 font-semibold">
                            {{-- Top section Modal --}}
                                <div>
                                    <label for="nama" class="cursor-default py-1">Nama Cabang</label>
                                    <input wire:model.defer="nama" id="nama" class="inputBox" type="text" required autocomplete="off">

                                    <div class="flex justify-between space-x-10">
                                        <div>
                                            <label for="kode" class="cursor-default">Kode Cabang</label>
                                            <input id="kode" wire:model.defer="kode" class="inputBox" type="text" required autocomplete="off">
                                            @error('kode')
                                                <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="regional" class="cursor-default">Regional</label>
                                            <input id="regional" wire:model.defer="regional" class="inputBox" type="text" required autocomplete="off">
                                            @error('regional')
                                                <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <label for="alamat" class="cursor-default py-1">Alamat</label>
                                    <textarea id="alamat" wire:model.defer="alamat" class="inputBox" required autocomplete="off"> </textarea>
                                </div>
                            {{-- End Top section Modal --}}
                            </div>

                            {{-- PIC Section Modal --}}
                                <div class="border-t-2 -px-8 border-gray-200 mt-5" x-data="{picSearch: false}">
                                    <div class="space-y-1 mx-10 font-semibold ">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="cursor-default py-1 text-center">PIC</p>
                                                    {{-- Load state Livewire --}}
                                                    <div class="relative">
                                                    <div wire:loading wire:target="picSearch" class="absolute right-0 animate-spin opacity-50 mt-1 mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class=" w-4 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                {{-- End Load state Livewire --}}
                                                <input wire:model="picSearch" @focus="picSearch = true" @click.away="picSearch = false" class="inputBox"  type="text" placeholder="Cari Nama Pic..." autocomplete="off">
                                                @if (strlen($picSearch) > 0)
                                                <div x-show="picSearch">
                                                    <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                                        @if ($pic)
                                                            @forelse ($pic as $value)
                                                                <button @click="picSearch = false" wire:click="choosePic({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{ ($value['nik']) ? $value['nik'] : '-' }} | {{  $value['nama'] }}</li></button>
                                                            @empty
                                                                <span class="text-sm font-normal"> Data PIC tidak ditemukan!</span>
                                                            @endforelse
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                @if ($addNewPic == false)
                                                    <button type="button" wire:click="addPic" class="mt-8 bg-blue-500 font-semibold text-white px-4 py-2 rounded-xl hover:bg-blue-700 duration-200 focus:outline-none">Tambah PIC</button>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div>
                                            <label for="picName" class="cursor-default">Nama PIC</label>
                                            <input id="picName" wire:model.defer="picName" class="inputBox" type="text" required {{ ($addNewPic == false) ? 'disabled' : '' }} autocomplete="off">
                                            @error('picName')
                                                <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="flex justify-between space-x-10">
                                            <div>
                                                <label for="picNik" class="cursor-default">NIK PIC</label>
                                                <input id="picNik" wire:model.defer="picNik" class="inputBox" type="text" {{ ($addNewPic == false) ? 'disabled' : '' }} autocomplete="off">
                                                @error('picNik')
                                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="no_telp" class="cursor-default">Nomor Telepon PIC</label>
                                                <input id="no_telp" wire:model.defer="no_telp" class="inputBox"  type="text" {{ ($addNewPic == false) ? 'disabled' : '' }} autocomplete="off">
                                                @error('no_telp')
                                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- End PIC Section Modal --}}
                        </div>
                        <div class="border-t-2 border-gray-200 mt-2">
                            <div class="flex justify-end space-x-8 p-3">
                            {{-- Type button agar tidak dianggap submit ama livewire --}}
                            <button type="button" @click="isOpen = false" x-on:click="$wire.resetData()" class="text-red-500 font-semibold focus:outline-none">Close</button>
                            <button type="submit" class="bg-blue-500 font-semibold text-white px-4 py-2 rounded-xl hover:bg-blue-700 duration-200 focus:outline-none">Simpan</button>
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
                    'Cabang berhasil dihapus',
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