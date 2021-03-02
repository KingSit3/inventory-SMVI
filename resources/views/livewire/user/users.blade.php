<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Users Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                        <button @click="isOpen = true" wire:click="add" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah User</button>
                        
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari User & NIK...">
                            </div>
                        </div>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">NIK</th>
                            <th class="w-1/3">Nama</th>
                            <th class="w-1/3">No Telp</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td>{{ ($users->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ ($user['nik']) ? $user['nik'] : '-' }}</td>
                            <td class="truncate capitalize">{{ $user['name'] }}</td>
                            <td>{{ ($user['no_telp']) ? $user['no_telp'] : '-' }}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">
                            
                                <button @click="isOpen = true" wire:click="edit({{ $user['id'] }})" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                </button>

                                <button wire:click="$emit('delete', {{ $user['id'] }})" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-red-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
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
                    {{ $users->links() }}
                </div>
            {{-- End Pagination --}}
        </div>

        {{-- modal --}}
            <div 
                x-show="isOpen"
                class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start">
                <div x-show.transition.duration.150ms="isOpen" @click.away="isOpen = false" x-on:click.away="$wire.resetData()" class="w-1/3 mt-10 bg-white opacity-100 rounded-xl shadow-xl">
                    <form wire:submit.prevent="{{ $submitType }}">
                        <div class="px-8 py-6">
                            <div class="text-center">
                                <span class="text-xl font-semibold capitalize">{{ $submitType }} Data</span>
                            </div>
                            <div class="mt-4 space-y-1 mx-10 font-semibold">
                                <p class="cursor-default">NIK</p>
                                <input wire:model="nik" class="ring-2 ring-gray-300 rounded-md pl-2.5 pr-2.5 focus:outline-none outline-none duration-200 focus:ring-2 focus:ring-blue-400 focus:shadow-lg w-full"  type="text">
                                @error('nik')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                                <p class="cursor-default pt-3">Nama</p>
                                <input wire:model="name" class="ring-2 ring-gray-300 rounded-md pl-2.5 pr-2.5 focus:outline-none outline-none duration-200 focus:ring-2 focus:ring-blue-400 focus:shadow-lg w-full"  type="text">
                                @error('name')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                                <p class="cursor-default pt-3">Nomor Telepon</p>
                                <input wire:model="no_telp" class="ring-2 ring-gray-300 rounded-md pl-2.5 pr-2.5 focus:outline-none outline-none duration-200 focus:ring-2 focus:ring-blue-400 focus:shadow-lg w-full"  type="text">
                                @error('no_telp')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="border-t-2 border-gray-200 mt-5">
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

    

