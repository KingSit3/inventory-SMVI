<div>
    <div x-data="{detailLog: false}" class="px-7 py-3 flex flex-col justify-between h-screen">
        <div>
            {{-- Top Bar --}}
            <div class="text-2xl text-center font-bold  cursor-default">
                <p class="{{ ($logDo['deleted_at']) ? 'text-red-500' : 'text-blue-600' }}">Info Log Image {{ $logDo['kode_image'] }}</p>
            </div>
           
            {{-- End Top Bar --}}

            {{-- Top Section --}}
                <div class="flex justify-start px-5 mb-5">
                    <div class="flex flex-col font-semibold">
                        <table>
                            <tr>
                                <td class="pr-3">No Delivery Order</td>
                                <td>:</td>
                                <td>{{ $logData['no_do'] }}</td>
                            </tr>
                            <tr>
                                <td class="pr-3">Status Image</td>
                                <td>:</td>
                                <td class="font-semibold capitalize rounded-lg {{ ($logData['deleted_at']) ? 'text-red-500' : 'text-blue-500' }}">{{ ($logData['deleted_at']) ? 'Terhapus' : 'Aktif' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            {{-- End Top Section --}}

            {{-- Table --}}
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-1/12">No</th>
                            <th class="w-1/6">No DO</th>
                            <th class="w-1/6">Perubahan</th>
                            <th class="w-1/6">Oleh</th>
                            <th class="w-1/6">Tanggal Log</th>
                            <th class="w-1/5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logDo as $value)
                        <tr class="text-center items-center {{ ($loop->odd) ? "bg-indigo-100 bg-opacity-75" : "" }}">
                            <td class="py-2">{{ ($logDo->firstItem()-1) + $loop->iteration }}</td>
                            <td>{{ $value['deliveryOrder']['no_do']}}</td>
                            <td class="capitalize">{{ $value['data_log']['aksi']}} Data</td>
                            <td class="capitalize">{{ $value['data_log']['edited_by']}}</td>
                            <td>{{ $value['tanggal'] }}</td>

                            <td class="space-x-4 py-1 flex items-center justify-center">
                                <button @click="detailLog = true" wire:click="$emit('detailLogDeliveryOrder', {{ $value['id'] }})" class="focus:outline-none" title="Info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 text-gray-500 hover:text-blue-500 py-1 duration-150 font-bold" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center pt-5 text-red-500" colspan="6">
                            Data Tidak ditemukan!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            {{-- End Table --}}
            <div 
            x-show="detailLog"
            class="z-50 fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start overflow-y-auto">
                <livewire:log.detail.detail-delivery-order />
            </div>
        </div>
        <div>
            {{-- Pagination --}}
                <div class="mt-2 mx-5">
                    {{ $logDo->links() }}
                </div>
            {{-- End Pagination --}}
        </div>
    </div>
</div>

    

