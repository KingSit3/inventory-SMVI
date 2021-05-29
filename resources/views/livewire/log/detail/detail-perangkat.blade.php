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
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['Perangkat']['sn_pengganti'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Perangkat:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['Perangkat']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['Perangkat']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
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
                            <td width="45%">SN Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sn_lama']) ? $dataLog['data_log']['data_baru']['sn_lama'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Perangkat Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_baru']['sn_pengganti'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Monitor Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sn_monitor']) ? $dataLog['data_log']['data_baru']['sn_monitor'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['tipe']) ? $dataLog['data_log']['data_baru']['tipe'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">User Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['user']) ? $dataLog['data_log']['data_baru']['user'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Sistem Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sistem']) ? $dataLog['data_log']['data_baru']['sistem'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['cabang']) ? $dataLog['data_log']['data_baru']['cabang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">No Pengiriman Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['no_pengiriman']) ? $dataLog['data_log']['data_baru']['no_pengiriman'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Gelombang Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['gelombang']) ? $dataLog['data_log']['data_baru']['gelombang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Keterangan Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['ket']) ? $dataLog['data_log']['data_baru']['ket'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Status Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['cek_status']) ? $dataLog['data_log']['data_baru']['cek_status'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Perolehan Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['perolehan']) ? $dataLog['data_log']['data_baru']['perolehan'] : '-' }}</td>
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
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['perangkat']['sn_pengganti'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Perangkat:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['perangkat']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['perangkat']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
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
                            <td width="45%">SN Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sn_lama']) ? $dataLog['data_log']['data_baru']['sn_lama'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Perangkat Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_baru']['sn_pengganti'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Monitor Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sn_monitor']) ? $dataLog['data_log']['data_baru']['sn_monitor'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['tipe']) ? $dataLog['data_log']['data_baru']['tipe'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">User Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['user']) ? $dataLog['data_log']['data_baru']['user'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Sistem Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['sistem']) ? $dataLog['data_log']['data_baru']['sistem'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['cabang']) ? $dataLog['data_log']['data_baru']['cabang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">No Pengiriman Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['no_pengiriman']) ? $dataLog['data_log']['data_baru']['no_pengiriman'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Gelombang Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['gelombang']) ? $dataLog['data_log']['data_baru']['gelombang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Keterangan Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['ket']) ? $dataLog['data_log']['data_baru']['ket'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Status Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['cek_status']) ? $dataLog['data_log']['data_baru']['cek_status'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Perolehan Baru</td>
                            <td width="5%">:</td>
                            <td class="bg-green-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_baru']['perolehan']) ? $dataLog['data_log']['data_baru']['perolehan'] : '-' }}</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="45%">SN Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['sn_lama']) ? $dataLog['data_log']['data_lama']['sn_lama'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Perangkat Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ $dataLog['data_log']['data_lama']['sn_pengganti'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Monitor Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['sn_monitor']) ? $dataLog['data_log']['data_lama']['sn_monitor'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['tipe']) ? $dataLog['data_log']['data_lama']['tipe'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">User Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['user']) ? $dataLog['data_log']['data_lama']['user'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Sistem Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['sistem']) ? $dataLog['data_log']['data_lama']['sistem'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['cabang']) ? $dataLog['data_log']['data_lama']['cabang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">No Pengiriman Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['no_pengiriman']) ? $dataLog['data_log']['data_lama']['no_pengiriman'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Gelombang Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['gelombang']) ? $dataLog['data_log']['data_lama']['gelombang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Keterangan Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['ket']) ? $dataLog['data_log']['data_lama']['ket'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Status Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['cek_status']) ? $dataLog['data_log']['data_lama']['cek_status'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Perolehan Lama</td>
                            <td width="5%">:</td>
                            <td class="bg-red-500 bg-opacity-20" width="50%">{{ ($dataLog['data_log']['data_lama']['perolehan']) ? $dataLog['data_log']['data_lama']['perolehan'] : '-' }}</td>
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
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['perangkat']['sn_pengganti'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Perangkat:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['perangkat']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['perangkat']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
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
                            <td width="45%">SN Lama</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sn_lama']) ? $dataLog['data_log']['data_lama']['sn_lama'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Perangkat</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['data_lama']['sn_pengganti'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Monitor</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sn_monitor']) ? $dataLog['data_log']['data_lama']['sn_monitor'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['tipe']) ? $dataLog['data_log']['data_lama']['tipe'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">User</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['user']) ? $dataLog['data_log']['data_lama']['user'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Sistem</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sistem']) ? $dataLog['data_log']['data_lama']['sistem'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['cabang']) ? $dataLog['data_log']['data_lama']['cabang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">No Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['no_pengiriman']) ? $dataLog['data_log']['data_lama']['no_pengiriman'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Gelombang</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['gelombang']) ? $dataLog['data_log']['data_lama']['gelombang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Keterangan</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['ket']) ? $dataLog['data_log']['data_lama']['ket'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Status</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['cek_status']) ? $dataLog['data_log']['data_lama']['cek_status'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Perolehan</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['perolehan']) ? $dataLog['data_log']['data_lama']['perolehan'] : '-' }}</td>
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
                    <span class="text-xl font-semibold capitalize">Detail Log {{ $dataLog['perangkat']['sn_pengganti'] }}</span>
                </div>
                <div class="text-center my-2">
                    <span class="text-xl font-semibold capitalize">Status Perangkat:</span>
                    <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataLog['perangkat']['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">{{ ($dataLog['perangkat']['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
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
                            <td width="45%">SN Lama</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sn_lama']) ? $dataLog['data_log']['data_lama']['sn_lama'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Perangkat</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ $dataLog['data_log']['data_lama']['sn_pengganti'] }}</td>
                        </tr>
                        <tr>
                            <td width="45%">SN Monitor</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sn_monitor']) ? $dataLog['data_log']['data_lama']['sn_monitor'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['tipe']) ? $dataLog['data_log']['data_lama']['tipe'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">User</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['user']) ? $dataLog['data_log']['data_lama']['user'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Tipe Sistem</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['sistem']) ? $dataLog['data_log']['data_lama']['sistem'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Cabang</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['cabang']) ? $dataLog['data_log']['data_lama']['cabang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">No Pengiriman</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['no_pengiriman']) ? $dataLog['data_log']['data_lama']['no_pengiriman'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Gelombang</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['gelombang']) ? $dataLog['data_log']['data_lama']['gelombang'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Keterangan</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['ket']) ? $dataLog['data_log']['data_lama']['ket'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Status</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['cek_status']) ? $dataLog['data_log']['data_lama']['cek_status'] : '-' }}</td>
                        </tr>
                        <tr>
                            <td width="45%">Perolehan</td>
                            <td width="5%">:</td>
                            <td width="50%">{{ ($dataLog['data_log']['data_lama']['perolehan']) ? $dataLog['data_log']['data_lama']['perolehan'] : '-' }}</td>
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