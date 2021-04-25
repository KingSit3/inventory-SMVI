<div 
    class="w-1/3 mt-10 mb-10 bg-white opacity-100 rounded-xl shadow-xl">
    <div class="px-8 py-6">
        <div class="text-center">
            <span class="text-xl font-semibold capitalize">Detail Perangkat</span>
        </div>

        {{-- While Loading State --}}
        <div class="text-center mt-3">
            <span wire:loading class="font-semibold">Memuat Data...</span>
        </div>
        {{-- End While Loading State --}}

        @if ($dataPerangkat)
        <div class="text-center my-2">
            <span class="text-xl font-semibold capitalize">Status Perangkat:</span>
            <span class="font-semibold capitalize p-2 text-white rounded-lg {{ ($dataPerangkat['deleted_at']) ? 'bg-red-500' : 'bg-blue-500' }}">{{ ($dataPerangkat['deleted_at']) ? 'Terhapus' : 'Aktif' }}</span>
        </div>
        {{-- Table Content --}}
            <table width="100%" class="font-semibold mt-3">
                <tr>
                    <td width="45%">Serial Number Lama</td>
                    <td width="5%">:</td>
                    <td width="50%"> {{ ($dataPerangkat['sn_lama']) ? $dataPerangkat['sn_lama'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Serial Number baru</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['sn_pengganti']) ? $dataPerangkat['sn_pengganti'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Serial Number Monitor</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['sn_monitor']) ? $dataPerangkat['sn_monitor'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Tipe Perangkat</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_tipe']) ? $dataPerangkat['TipePerangkat']['kode_perangkat'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Image Perangkat</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_image']) ? $dataPerangkat['Image']['kode_image'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Perolehan</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['perolehan']) ? $dataPerangkat['perolehan'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">Status</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['cek_status']) ? $dataPerangkat['cek_status'] : '-' }}</td>
                </tr>
                <tr style="vertical-align: top">
                    <td width="45%">keterangan</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['keterangan']) ? $dataPerangkat['keterangan'] : '-' }}</td>
                </tr>
                

                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td width="45%">Nama User</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_user']) ? $dataPerangkat['Users']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">NIK User</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_user']) ? $dataPerangkat['Users']['nik'] : '-' }}</td>
                </tr>

                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td width="45%">Witel</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_witel']) ? $dataPerangkat['Witel']['nama_witel'] : '-' }}</td>
                </tr>
                <tr>
                    <td width="45%">No DO</td>
                    <td width="5%">:</td>
                    <td width="50%">{{ ($dataPerangkat['id_do']) ? $dataPerangkat['DeliveryOrder']['no_do'] : '-' }}</td>
                </tr>
                
            </table>
        {{-- End Table Content --}}
        @endif
    </div>
    <div class="border-t-2 border-gray-200 mt-5">
        <div class="flex justify-end space-x-8 p-5 mr-5">
        {{-- Type button agar tidak dianggap submit ama livewire --}}
        <button type="button" @click="infoPerangkat = false" wire:click="resetData" class="text-red-500 font-semibold focus:outline-none">Close</button>
        </div>
    </div>
</div>