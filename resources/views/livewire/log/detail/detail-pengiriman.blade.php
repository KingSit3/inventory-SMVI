<div class="mt-10 mb-5 bg-white opacity-100 rounded-xl shadow-xl">
    {{-- Agar tidak langsung dieksekusi sebelum dapat ID --}}
    {{-- While Loading State --}}
    <div class="text-center m-28">
        <span wire:loading class="font-semibold">Memuat Data...</span>
    </div>
    {{-- End While Loading State --}}
    @if ($dataLog)
    
        {{-- Jika Tambah data --}}
        @if ($dataLog['data_log']['aksi'] == 'Tambah')
        <div class="mx-2 -mt-28">
            <div class="px-6 py-6">
                <div class="text-center">
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['pengiriman']['no_pengiriman'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Pengiriman:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['pengiriman']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['pengiriman']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
                </div>
                {{-- Table Content --}}
                    <table width="100%" class="font-semibold mt-3">
                        <tr>
                            <td width="45%">Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%"> {{ $dataLog['data_log']['aksi'] }} Data</td>
                        </tr>
                        <tr>
                            <td width="45%">Oleh</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['edited_by'] }}</td>
                        </tr>
                        <tr class="align-top">
                            <td width="45%">Browser</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['browser'] }}</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">No Pengiriman baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_baru']['no_pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tanggal Pengiriman baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ date('d-M-Y', strtotime($dataLog['data_log']['data_baru']['tanggal_pengiriman'])) }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%"><a class="hover:text-blue-500 duration-200" href="/cabang/{{ $dataLog['data_log']['data_baru']['id_cabang'] }}">{{ $dataLog['data_log']['data_baru']['nama_cabang'] }}</a></td>
                        </tr>
    
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">Tanggal Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['tanggal'] }}</td>
                        </tr>
                    </table>
                {{-- End Table Content --}}
            </div>
            <div class="border-t-2 border-gray-200 mt-5">
                <div class="flex justify-end space-x-8 p-5 mr-5">
                {{-- Type button agar tidak dianggap submit ama livewire --}}
                <button type="button" @click="detailLog = false" wire:click="resetData" class="text-red-500 font-semibold focus:outline-none">Close</button>
                </div>
            </div>
        </div>
    
        {{-- Jika Edit data --}}
        @elseif ($dataLog['data_log']['aksi'] == 'Edit')
        <div class="mx-2 -mt-28">
            <div class="px-6 py-6">
                <div class="text-center">
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['pengiriman']['no_pengiriman'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Pengiriman:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['pengiriman']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['pengiriman']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
                </div>
                {{-- Table Content --}}
                    <table width="100%" class="font-semibold mt-3">
                        <tr>
                            <td width="45%">Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%"> {{ $dataLog['data_log']['aksi'] }} Data</td>
                        </tr>
                        <tr>
                            <td width="45%">Oleh</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['edited_by'] }}</td>
                        </tr>
                        <tr class="align-top">
                            <td width="45%">Browser</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['browser'] }}</td>
                        </tr>
    
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">No Pengiriman baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_baru']['no_pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tanggal Pengiriman baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ date('d-M-Y', strtotime($dataLog['data_log']['data_baru']['tanggal_pengiriman'])) }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%"><a class="hover:text-blue-500 duration-200" href="/cabang/{{ $dataLog['data_log']['data_baru']['id_cabang'] }}">{{ $dataLog['data_log']['data_baru']['nama_cabang'] }}</a></td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">No Pengiriman Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_lama']['no_pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tanggal Pengiriman Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ date('d-M-Y', strtotime($dataLog['data_log']['data_lama']['tanggal_pengiriman'])) }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%"><a class="hover:text-blue-500 duration-200" href="/cabang/{{ $dataLog['data_log']['data_lama']['id_cabang'] }}">{{ $dataLog['data_log']['data_lama']['nama_cabang'] }}</a></td>
                        </tr>
    
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">Tanggal Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['tanggal'] }}</td>
                        </tr>
                    </table>
                {{-- End Table Content --}}
            </div>
            <div class="border-t-2 border-gray-200 mt-5">
                <div class="flex justify-end space-x-8 p-5 mr-5">
                {{-- Type button agar tidak dianggap submit ama livewire --}}
                <button type="button" @click="detailLog = false" wire:click="resetData" class="text-red-500 font-semibold focus:outline-none">Close</button>
                </div>
            </div>
        </div>
    
        {{-- Jika hapus Data --}}
        @elseif ($dataLog['data_log']['aksi'] == 'Hapus')
        <div class="mx-2 -mt-28">
            <div class="px-6 py-6">
                <div class="text-center">
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['pengiriman']['no_pengiriman'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Pengiriman:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['pengiriman']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['pengiriman']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
                </div>
                {{-- Table Content --}}
                    <table width="100%" class="font-semibold mt-3">
                        <tr>
                            <td width="45%">Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%"> {{ $dataLog['data_log']['aksi'] }} Data</td>
                        </tr>
                        <tr>
                            <td width="45%">Oleh</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['edited_by'] }}</td>
                        </tr>
                        <tr class="align-top">
                            <td width="45%">Browser</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['browser'] }}</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">No Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['data_lama']['no_pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tanggal Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ date('d-M-Y', strtotime($dataLog['data_log']['data_lama']['tanggal_pengiriman'])) }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Lama</td>
                            <td width="5%">:</td>
                            <td width="50%"><a class="hover:text-blue-500 duration-200" href="/cabang/{{ $dataLog['data_log']['data_lama']['id_cabang'] }}">{{ $dataLog['data_log']['data_lama']['nama_cabang'] }}</a></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">Tanggal Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['tanggal'] }}</td>
                        </tr>
                    </table>
                {{-- End Table Content --}}
            </div>
            <div class="border-t-2 border-gray-200 mt-5">
                <div class="flex justify-end space-x-8 p-5 mr-5">
                {{-- Type button agar tidak dianggap submit ama livewire --}}
                <button type="button" @click="detailLog = false" wire:click="resetData" class="text-red-500 font-semibold focus:outline-none">Close</button>
                </div>
            </div>
        </div>
    
        {{-- Jika Restore Data --}}
        @else
        <div class="mx-2 -mt-28">
            <div class="px-6 py-6">
                <div class="text-center">
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['pengiriman']['no_pengiriman'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Pengiriman:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['pengiriman']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['pengiriman']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
                </div>
                {{-- Table Content --}}
                    <table width="100%" class="font-semibold mt-3">
                        <tr>
                            <td width="45%">Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%"> {{ $dataLog['data_log']['aksi'] }} Data</td>
                        </tr>
                        <tr>
                            <td width="45%">Oleh</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['edited_by'] }}</td>
                        </tr>
                        <tr class="align-top">
                            <td width="45%">Browser</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['browser'] }}</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">No Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['data_lama']['no_pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tanggal Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ date('d-M-Y', strtotime(date('d-M-Y', strtotime($dataLog['data_log']['data_lama']['tanggal_pengiriman'])))) }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Lama</td>
                            <td width="5%">:</td>
                            <td width="50%"><a class="hover:text-blue-500 duration-200" href="/cabang/{{ $dataLog['data_log']['data_lama']['id_cabang'] }}">{{ $dataLog['data_log']['data_lama']['nama_cabang'] }}</a></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">Tanggal Aksi</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['tanggal'] }}</td>
                        </tr>
                    </table>
                {{-- End Table Content --}}
            </div>
            <div class="border-t-2 border-gray-200 mt-5">
                <div class="flex justify-end space-x-8 p-5 mr-5">
                {{-- Type button agar tidak dianggap submit ama livewire --}}
                <button type="button" @click="detailLog = false" wire:click="resetData" class="text-red-500 font-semibold focus:outline-none">Close</button>
                </div>
            </div>
        </div>
        @endif
    
    @endif
    </div>