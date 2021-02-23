<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <title>Admin</title>
    @livewireStyles
</head>
<body class="flex bg-gray-100">

    {{-- Sidabar --}}
        <div class="w-72 h-screen flex flex-col justify-between bg-gradient-to-t from-indigo-700 to-indigo-600 text-indigo-100 text-opacity-80  font-semibold">
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
                {{-- Users --}}
                <div x-data="{open: false}">
                    <div class="mt-1 mr-3 group">
                        <a class="cursor-pointer" @click="open = true">
                        <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                            <div class="flex">
                                <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="ml-3 group-hover:text-white flex items-center duration-150">Users</span>
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
                        <a href="users" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Users</a>
                        <a href="deletedusers" class="ml-3 mr-3 p-2 rounded-xl block hover:text-white hover:bg-indigo-500 text-indigo-500  items-center duration-150">Deleted Users</a>
                    </div>
                </div>  
                {{-- End Users --}}
                <div class="mt-1 mr-3 group">
                    <a href="/perangkat">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Perangkat</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="mt-1 mr-3 group">
                    <a href="/tipe">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Tipe Perangkat</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="mt-1 mr-3 group">
                    <a href="/witel">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Witel</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="mt-1 mr-3 group">
                    <a href="/image">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Image</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="mt-1 mr-3 group">
                    <a href="/do">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Delivery Order</span>
                        </div>
                    </div>
                    </a>
                </div>
            {{-- End SIdebar List --}}
            </div>
            <div class="flex space-x-3 py-2 mb-2 border-t-2 border-indigo-600 border-opacity-80">
                <div class="mx-4 flex items-center">
                    {{-- <img class="w-9 rounded-full" src="{{ asset('image/logo.jpg') }}" alt="Profile"> --}}
                </div>
                <div class="font-normal flex flex-col leading-8">
                    <span class="text-white cursor-default">MyPonyAsia</span>
                    <span class="text-xs font-semibold">
                       <a class="hover:opacity-100 opacity-50" href="#">View Profile</a>
                    </span>
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