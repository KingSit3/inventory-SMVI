<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @stack('topScript')
    <title>Inventory</title>
    @livewireStyles
</head>
<body class="flex bg-gray-100">

    {{-- Sidabar --}}
        <div class="w-72 h-screen flex flex-col justify-between bg-gradient-to-t from-indigo-700 to-indigo-600 text-indigo-100 text-opacity-80 font-semibold overflow-y-scroll">
            <div class="pl-5 pt-4">
            {{-- Logo --}}
                <div class="mt-3">

                    {{-- SVG Logo --}}
                    <div class="flex group">
                        <div class="opacity-80 group-hover:opacity-100 group-hover:text-white">
                            <a href="#">
                                <svg class="w-11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                </svg>   
                            </a> 
                        </div>
                        <div class="flex group-hover:opacity-100 opacity-90 items-center ml-2 text-2xl font-bold text-white">
                            <a href="">
                                Workflow
                            </a>
                        </div>
                    </div>
                </div>
            {{-- End Logo --}}

            {{-- SideBar List --}}
                <div class="mt-3 mr-3 group">
                    <a href="/">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="transform translate- group-hover: group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Dashboard</span>
                        </div>
                    </div>
                    </a>
                </div>

                {{-- Master Data --}}
                    <div x-data="{open: false}">
                        <div class="mt-1 mr-3 group">
                            <a class="cursor-pointer" @click="open = true">
                            <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                                <div class="flex">
                                    <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="ml-3 group-hover:text-white flex items-center duration-150">Master Data</span>
                                </div>
                                
                            </div>
                            </a>
                        </div>
                        <div x-show="open"
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90"
                            class="bg-gray-100 space-y-2 mr-4 py-2 rounded-xl">
                            <a href="/users" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">User</a>
                            <a href="/perangkat" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Perangkat</a>
                            <a href="/cabang" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Cabang</a>
                            <a href="/tipesistem" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Tipe Sistem</a>
                            <a href="/tipe" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Tipe Perangkat</a>
                            <a href="/gelombang" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Gelombang</a>
                            <a href="/pengiriman" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">pengiriman</a>
                        </div>
                    </div>  
                {{-- End Master Data --}}

                {{-- Master Data Terhapus --}}
                    <div x-data="{open: false}">
                        <div class="mt-1 mr-3 group">
                            <a class="cursor-pointer" @click="open = true">
                            <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="group-hover:text-white duration-150 w-7" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="ml-3 group-hover:text-white flex items-center duration-150">Data Terhapus</span>
                                </div>
                                
                            </div>
                            </a>
                        </div>
                        <div x-show="open"
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90"
                            class="bg-gray-100 space-y-2 mr-4 py-2 rounded-xl">
                            <a href="/deletedusers" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">User Terhapus</a>
                            <a href="/deletedperangkat" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Perangkat Terhapus</a>
                            <a href="/deletedcabang" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Cabang Terhapus</a>
                            <a href="/deletedtipesistem" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Tipe Sistem Terhapus</a>
                            <a href="/deletedtipe" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Tipe Perangkat Terhapus</a>
                            <a href="/deletedpengiriman" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Pengiriman Terhapus</a>
                        </div>
                    </div>  
                {{-- End Master Data Terhapus --}}
                
                {{-- Log --}}
                    <div x-data="{open: false}">
                        <div class="mt-1 mr-3 group">
                            <a class="cursor-pointer" @click="open = true">
                            <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                                <div class="flex">
                                    <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="ml-3 group-hover:text-white flex items-center duration-150">Log</span>
                                </div>
                                
                            </div>
                            </a>
                        </div>
                        <div x-show="open"
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90"
                            class="bg-gray-100 space-y-2 mr-4 py-2 rounded-xl">
                            <a href="/loguser" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log User</a>
                            <a href="/logperangkat" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log Perangkat</a>
                            <a href="/logcabang" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log Cabang</a>
                            <a href="/logtipesistem" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log Tipe Sistem</a>
                            <a href="/logtipeperangkat" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log Tipe Perangkat</a>
                            <a href="/logpengiriman" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Log Pengiriman</a>
                        </div>
                    </div>  
                {{-- End Log --}}

                @if (session('role') == 0)
                {{-- Debug --}}
                <div class="mt-1 mr-3 group">
                    <a href="/telescope">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" >
                                <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Debug</span>
                        </div>
                    </div>
                    </a>
                </div>
                {{-- End Debug --}}

                {{-- Admin --}}
                <div class="mt-1 mr-3 group">
                    <a href="/admin">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Admin</span>
                        </div>
                    </div>
                    </a>
                </div>
                {{-- End Admin --}}
                @endif

            {{-- End SIdebar List --}}
            </div>
            <div class="flex space-x-3 mb-2 border-t-2 border-indigo-600 border-opacity-80">
                <div class="mx-4 flex items-center">
                    {{-- <img class="w-9 rounded-full" src="{{ asset('image/logo.jpg') }}" alt="Profile"> --}}
                </div>
                <div class="font-normal flex flex-col leading-8">
                    <span class="text-white cursor-default">{{ session('name') }}</span>
                    <a class="hover:text-white font-semibold duration-200" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    {{-- End Sidebar --}}
    
    {{-- Right Content --}}
        <div class="w-full">
            {{-- Content --}}
                @yield('content')
            {{-- End Content --}}
        </div>
    {{-- End Right Content --}}
    
    @livewireScripts
    @stack('script')
</body>
</html>