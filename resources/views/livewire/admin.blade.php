<div>
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Admin Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                        <button @click="isOpen = true" wire:click="add" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah Admin</button>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/3">Nama</th>
                            <th class="w-1/6">Email</th>
                            <th class="w-1/3">Login Terakhir</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admin as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($admin->firstItem()-1) + $loop->iteration }}</td>
                            <td class="truncate capitalize">{{ ($value['name']) }}</td>
                            <td>{{ $value['email'] }}</td>
                            <td>{{ ($value['last_login'])}}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <button @click="isOpen = true" wire:click="edit({{ $value['id'] }})" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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
                    {{ $admin->links() }}
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
                                <p class="cursor-default">Nama</p>
                                <input wire:model="nama" class="inputBox"  type="text" required>
                                @error('nama')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                                <p class="cursor-default pt-3">Email</p>
                                <input wire:model="email" class="inputBox"  type="email" required>
                                @error('email')
                                    <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                @enderror
                                <p class="cursor-default pt-3">Password</p>
                                <input wire:model="password" class="inputBox"  type="password" required>
                                @error('password')
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
