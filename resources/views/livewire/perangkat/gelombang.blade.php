<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>SP Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                        <div>
                        @if (session('role') != 2)
                            <button wire:click="$emit('tambah')" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah SP</button>
                        @endif
                        </div>
                </div>
            {{-- End Top Section --}}
            
            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">SP</th>
                            @if (session('role') != 2)
                            <th class="w-1/5">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gelombang as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($gelombang->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ ($value['nama_gelombang']) }}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <a href="/gelombang/{{ $value['nama_gelombang'] }}" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center pt-5 text-red-500" colspan="3">
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
                    {{ $gelombang->links() }}
                </div>
            {{-- End Pagination --}}
        </div>
    </div>

    {{-- Push Script To Template --}}
    @push('script')
        <script>
            document.addEventListener('livewire:load', function () {
                @this.on('tambah', id => {
                    // Jalankan sweet alert
                    Swal.fire({
                    title: 'Yakin Mau nambah SP?',
                    // text: "User ".name." akan dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Tambah!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // Panggil method livewire
                        @this.call('tambah')
                        // Pesan berhasil
                        Swal.fire(
                        'Berhasil!',
                        'Data SP berhasil ditambah',
                        'success'
                        )
                    }
                    })
                })
            })
        </script>
    @endpush
</div>

    

