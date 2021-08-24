@extends('layouts.app')
@section('content')
@push('topScript')
<script src="{{ asset('js/chart.js') }}"></script>
@endpush
    
    <div class="p-6">
        {{-- Top Section --}}
            <div class="flex justify-evenly space-x-14">

                {{-- Card --}}
                    <div class="bg-yellow-500 w-1/5 h-24 shadow-md rounded-lg pl-1.5">
                        <div class="w-full h-full bg-white flex justify-around items-center space-x-2 shadow-md rounded-lg px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div class="flex flex-col items-center text-gray-600">
                                <div class="font-bold">Perangkat</div>
                                <div class="font-semibold">{{ $jumlahPerangkat }}</div>
                            </div>
                        </div>
                    </div>
                {{-- End Card --}}
                {{-- Card --}}
                    <div class="bg-green-500 w-1/5 h-24 shadow-md rounded-lg pl-1.5">
                        <div class="w-full h-full bg-white flex justify-around items-center space-x-2 shadow-md rounded-lg px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div class="flex flex-col items-center text-gray-600">
                                <div class="font-bold">User</div>
                                <div class="font-semibold">{{ $jumlahUser }}</div>
                            </div>
                        </div>
                    </div>
                {{-- End Card --}}
                {{-- Card --}}
                    <div class="bg-purple-500 w-1/5 h-24 shadow-md rounded-lg pl-1.5">
                        <div class="w-full h-full bg-white flex justify-around items-center space-x-2 shadow-md rounded-lg px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div class="flex flex-col items-center text-gray-600">
                                <div class="font-bold">Cabang</div>
                                <div class="font-semibold">{{ $jumlahCabang }}</div>
                            </div>
                        </div>
                    </div>
                {{-- End Card --}}
                {{-- Card --}}
                    <div class="bg-blue-500 w-1/5 h-24 shadow-md rounded-lg pl-1.5">
                        <div class="w-full h-full bg-white flex justify-around items-center space-x-2 shadow-md rounded-lg px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <div class="flex flex-col items-center text-gray-600">
                                <div class="font-bold">Pengiriman</div>
                                <div class="font-semibold">{{ $jumlahPengiriman }}</div>
                            </div>
                        </div>
                    </div>
                {{-- End Card --}}

            </div>
        {{-- End Top Section --}}

        {{-- Bottom Section --}}
        <div class="mt-5 flex justify-between space-x-5">
            <div class="w-1/2 bg-white rounded-lg shadow-lg">   
                <div class="bg-blue-500 rounded-t-xl text-center text-white font-bold py-1 ">
                    Download Dokumen pengiriman
                </div>
                <div class="flex flex-col bg-white px-5 -pl-10">
                    @forelse ($printPengiriman as $print)
                        <a href="{{ '/printpengiriman/'.$print['id'] }}" class="p-3 my-2 hover:bg-gray-200 font-semibold">{{ $print['no_pengiriman'] }}</a>
                    @empty
                        <p class="text-red"> Belum Ada Pengiriman</p>
                    @endforelse
                </div>
            </div>
            <div class="w-1/2 bg-white rounded-lg shadow-lg">   
                <div class="bg-blue-500 rounded-t-xl text-center text-white font-bold py-1 ">
                    Perangkat per Gelombang
                </div>
                <div class="flex flex-col bg-white px-5 -pl-10">
                    <canvas class="h-96" id="chartGelombang"></canvas>
                </div>
            </div>
        </div>
        {{-- End Bottom Section --}}
    </div>
    @push('script')
        <script>
        var namaGelombang = {!! json_encode($namaGelombang) !!};
        var totalGelombang = {!! json_encode($totalGelombang) !!};

        var ctx = document.getElementById('chartGelombang');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: namaGelombang,
                datasets: [{
                    label: 'My First Dataset',
                    data: totalGelombang,
                    backgroundColor: [
                    'rgb(88, 27, 152)',
                    'rgb(61, 90, 241)',
                    'rgb(243, 85, 142)',
                    'rgb(250, 238, 28)',
                    ],
                    hoverOffset: 6
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });
        </script>
    @endpush
@endsection