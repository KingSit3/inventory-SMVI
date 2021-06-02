<div>
    <div class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-red-500 cursor-default">
                <p class="capitalize">menu Pengiriman terhapus</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-end px-5 mb-5">
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari Pengiriman...">
                            </div>
                        </div>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">Pengiriman</th>
                            <th class="w-1/6">Cabang</th>
                            <th class="w-1/5">Tanggal Dihapus</th>
                            @if (session('role') != 2)
                                <th class="w-1/5">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengiriman as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-red-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($pengiriman->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ ($value['no_pengiriman']) }}</td>
                            <td>{{ ($value['cabang']['nama_cabang']) }}</td>
                            <td>{{ $value['tanggal'] }}</td>

                            @if (session('role') != 2)
                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <button wire:click="$emit('restore', {{ $value['id'] }})" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
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
    </div>

    {{-- Push Script To Template --}}
    @push('script')
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('restore', id => {
                    // Jalankan sweet alert
                    Swal.fire({
                    title: 'Yakin ingin mengembalikkan Pengiriman ini?',
                    // text: "User ".name." akan dihapus",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Iya!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // Panggil method livewire
                        @this.call('restore', id)
                        // Pesan berhasil
                        Swal.fire(
                        'Berhasil!',
                        'Pengiriman berhasil dikembalikkan',
                        'success'
                        )
                    }
                    })
                })
            })
        </script>
    @endpush
</div>