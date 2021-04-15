<div>
    {{-- entangle agar interaksi dari controller: setelah data di save, modal tertutup --}}
    <div x-data="{isOpen: @entangle('isOpen').defer}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold text-indigo-600 cursor-default">
                <p>Perangkat Menu</p>
            </div>
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-between px-5 mb-5">
                    {{-- Tambah Button --}}
                    <div>
                        @if (session('role') != 2)
                        <button @click="isOpen = true" wire:click="add" class="bg-blue-500 hover:shadow-md hover:bg-blue-700 px-3 py-2 rounded-xl text-white font-semibold duration-150">Tambah Perangkat</button>
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
                                <input wire:model.debounce.200="keyword" class=" focus:ring-4 outline-none focus:outline-none ring-blue-300 rounded-full pl-7 py-1 duration-150" type="text" placeholder="Cari Sn...">
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
                            <th class="w-1/5">No Do</th>
                            <th class="w-1/12">SP</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perangkatData as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($perangkatData->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ $value['TipePerangkat']['kode_perangkat'] }}</td>
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
                            @if ($value['id_do'] != null)
                                <td>{{ $value['deliveryOrder']['no_do'] }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ ($value['sp']) ? $value['sp'] : '-' }}</td>
                            <td class="space-x-4 py-1 flex items-center justify-center">

                                <a href="/user/{{ $value['id'] }}" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>

                                @if (session('role') != 2)
                                <button @click="isOpen = true" wire:click="edit({{ $value['id'] }})" class="focus:outline-none" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-yellow-500 py-1 duration-150" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                
                                <button wire:click="$emit('delete', {{ $value['id'] }})" class="focus:outline-none" title="Delete">
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
                    {{ $perangkatData->links() }}
                </div>
            {{-- End Pagination --}}
        </div>

        {{-- modal --}}
            <div 
                x-show="isOpen"
                class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start overflow-y-auto">
                <div x-show.transition.duration.150ms="isOpen" class="w-3/6 my-5 bg-white opacity-100 rounded-xl shadow-xl">
                    <form wire:submit.prevent="{{ $submitType }}">
                        <div class="px-8 py-6">
                            <div class="text-center">
                                <span class="text-xl font-semibold capitalize">{{ $submitType }} Data</span>
                            </div>
                            <div class="mt-4 space-y-1 mx-10 font-semibold">
                                <div class="flex justify-between space-x-5">
                                    <div class="w-1/2">
                                        <label for="sn_lama" class="cursor-default">Serial Number lama</label>
                                        <input wire:model.defer="sn_lama" class="inputBox" id="sn_lama" type="text" autocomplete="off">
                                        <p class="text-xs text-gray-500">*Kosongkan jika tidak ada</p>
                                        @error('sn_lama')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2"></div>
                                </div>
                                <div class="flex justify-between space-x-6">
                                    <div class="w-1/2">
                                        <label for="sn_pengganti" class="cursor-default">Serial Number Pengganti</label>
                                        <input wire:model.defer="sn_pengganti" class="inputBox" id="sn_pengganti" type="text" required autocomplete="off">
                                        @error('sn_pengganti')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <label for="sn_monitor" class="cursor-default">Serial Number Monitor</label>
                                        <input wire:model.defer="sn_monitor" class="inputBox" id="sn_monitor" type="text" autocomplete="off">
                                        @error('sn_monitor')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex justify-between space-x-6">
                                    <div class="w-1/2">
                                        <p class="cursor-default pt-2">Tipe Perangkat</p>
                                        <select class="inputBox py-1" wire:model.defer="tipePerangkat" required>
                                            {{-- Wire:key sebagai pengganti opsi selected --}}
                                            <option wire:key="" value="">-- Pilih Tipe Perangkat --</option>
                                            @foreach ($tipe as $item)
                                                <option wire:key="{{ $item['kode_perangkat'] }}" value="{{ $item['id'] }}">{{ $item['nama_perangkat'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('tipePerangkat')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <p class="cursor-default pt-2">Image</p>
                                        <select class="inputBox py-1" wire:model.defer="imagePerangkat" required>
                                            {{-- Wire:key sebagai pengganti opsi selected --}}
                                            <option wire:key="" value="">-- Pilih Image --</option>
                                            @foreach ($image as $item)
                                                <option wire:key="{{ $item['kode_image'] }}" value="{{ $item['id'] }}">{{ $item['kode_image'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('imagePerangkat')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-between space-x-10 pt-2">
                                    {{-- User  --}}
                                    <div class="w-3/4">
                                        <label for="user" class="cursor-default">User</label>
                                        <div class="flex space-x-3">
                                            <div class="flex">
                                                <input wire:model="userSearch" @focus="userSearch = true" @click.away="userSearch = false" class="inputBox" id="user" type="text" placeholder="Cari User" autocomplete="off">
                                                <div wire:loading wire:target="userSearch" class="absolute animate-spin opacity-50 ml-44 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class=" w-5 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span wire:click="addUser" class="w-8 hover:text-blue-700 duration-100 cursor-pointer focus:outline-none outline-none" title="Tambah data User">
                                                <svg class="stroke-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        @if (strlen($userSearch) > 0)
                                            <div x-show="userSearch">
                                                <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                                    @if ($userResult)
                                                        @forelse ($userResult as $value)
                                                            <button @click="userSearch = false" wire:click="chooseUser({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{ ($value['nik']) ? $value['nik'] : '-' }} | {{  $value['name'] }}</li></button>
                                                        @empty
                                                            <span class="text-sm font-normal"> Data User tidak ditemukan!</span>
                                                        @endforelse
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <label class="cursor-default" for="namaUser">Nama User</label>
                                        <input id="namaUser" wire:model.defer="namaUser" class="inputBox" type="text" {{ ($addUser == true) ? "required" : "disabled" }} autocomplete="off">
                                        @error('namaUser')
                                            <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                        @enderror
                                        <div class="flex justify-between space-x-5">
                                            <div>
                                                <label class="cursor-default" for="nikUser">Nik</label>
                                                <input wire:model.defer="nikUser" id="nikUser" class="inputBox" type="text" {{ ($addUser == true) ? "" : "disabled" }} autocomplete="off">
                                                @error('nikUser')
                                                <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="cursor-default" for="telpUser">No Telp</label>
                                                <input wire:model.defer="telpUser" id="telpUser" class="inputBox" type="text" {{ ($addUser == true) ? "" : "disabled" }} autocomplete="off">
                                                @error('telpUser')
                                                <div class="text-red-500 text-sm font-normal">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-1/2"></div>
                                    {{-- End User --}}
                                </div>

                                {{-- Witel --}}
                                <div class="flex space-x-5">
                                    <div class="w-1/2 pt-3">
                                        <label for="witel" class="cursor-default pt-2">Witel</label>
                                        <div class="flex">
                                            <input wire:model="witelSearch" @focus="witelSearch = true" @click.away="witelSearch = false" class="inputBox" id="witel" type="text" placeholder="Cari witel" autocomplete="off">
                                            <div wire:loading wire:target="witelSearch" class="absolute animate-spin opacity-50 ml-60 mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class=" w-4 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @if (strlen($witelSearch) > 0)
                                            <div x-show="witelSearch">
                                                <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                                    @if ($witelResult)
                                                        @forelse ($witelResult as $value)
                                                            <button @click="witelSearch = false" wire:click="chooseWitel({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{  $value['kode_witel'].' | '.$value['nama_witel'] }}</li></button>
                                                        @empty
                                                            <span class="text-sm font-normal"> Data Witel tidak ditemukan!</span>
                                                        @endforelse
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <input wire:model.defer="witel" class="inputBox mt-3" type="text" disabled>
                                    </div>
                                    {{-- End Witel --}}
                                    {{-- DO --}}
                                    <div class="w-1/2 pt-3">
                                        <label for="doSearch" class="cursor-default pt-2">Delivery Order</label>
                                        <div class="flex">
                                            <input wire:model="doSearch" @focus="doSearch = true" @click.away="doSearch = false" class="inputBox" id="doSearch" type="text" placeholder="Cari do" autocomplete="off">
                                            <div wire:loading wire:target="doSearch" class="absolute animate-spin opacity-50 ml-60 mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class=" w-4 " fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @if (strlen($doSearch) > 0)
                                            <div x-show="doSearch">
                                                <ul class="absolute mt-2 bg-white border-gray-500 border-opacity-25 border-2 shadow-lg rounded-md w-52 px-2 py-2 space-y-1">
                                                    @if ($doResult)
                                                        @forelse ($doResult as $value)
                                                            <button @click="doSearch = false" wire:click="chooseDo({{ $value['id'] }})" class="w-full text-left p-1 hover:bg-black hover:bg-opacity-10 truncate" type="button"><li>{{  $value['no_do'] }}</li></button>
                                                        @empty
                                                            <span class="text-sm font-normal"> Data do tidak ditemukan!</span>
                                                        @endforelse
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <input wire:model.defer="kodeDo" class="inputBox mt-3" type="text" disabled>
                                    </div>
                                    {{-- End Do --}}
                                </div>
                                
                                {{-- SP --}}
                                <div class="w-1/2">
                                    <p class="cursor-default pt-2">SP</p>
                                    <select class="inputBox py-1" wire:model.defer="spPerangkat" required>
                                        {{-- Sengaja di kosongkan --}}
                                        <option wire:key="" value="">--Pilih Sp--</option>
                                        {{-- Wire:key sebagai pengganti opsi selected --}}
                                        @foreach ($sp as $item)
                                            <option wire:key="{{ $item['nama_sp'] }}" value="{{ $item['nama_sp'] }}">{{ $item['nama_sp'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- End SP --}}

                                <div class="flex justify-between space-x-5">
                                    <div class="w-1/2">
                                        <p class="cursor-default pt-2">Cek Status</p>
                                        <select class="inputBox py-1" wire:model.defer="cekStatus">
                                            <option value="">Tidak ada</option>
                                            <option wire:key="NPS" value="NPS">NPS</option>
                                            <option wire:key="OBC" value="OBC">OBC</option>
                                        </select>
                                    </div>
                                    <div class="w-1/2">
                                        <p class="cursor-default pt-2">Perolehan</p>
                                        <select class="inputBox py-1" wire:model.defer="perolehan" required>
                                            <option value="">-- Pilih Perolehan --</option>
                                            <option wire:key="NCD" value="NCD">NCD</option>
                                            <option wire:key="COD" value="COD">COD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="ket" class="cursor-default py-1">Keterangan</label>
                                    <textarea id="ket" wire:model.defer="ket" class="inputBox" autocomplete="off"> </textarea>
                                </div>

                            </div>
                        </div>
                        <div class="border-t-2 border-gray-200 mt-3">
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

    

