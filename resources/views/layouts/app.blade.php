<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
    @livewireStyles
</head>
<body>

    {{-- Sidabar --}}
        <div class="w-72 h-screen flex flex-col justify-between bg-gradient-to-t from-indigo-700 to-indigo-600 text-indigo-100 text-opacity-80  font-semibold">
            <div class="pl-5 pt-4">
            {{-- Logo --}}
                <div class="mt-3">
                    {{-- Image Logo --}}
                    {{-- <a href="#">
                        <img class="hover:opacity-75 hover:shadow-lg" src="{{ asset('image/ponytown.png') }}" alt="Logo">
                    </a> --}}

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
                    <a href="#">
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
                <div class="mt-1 mr-3 group">
                    <a href="#">
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
                <div class="mt-1 mr-3 group">
                    <a href="#">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Folder</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="mt-1 mr-3 group">
                    <a href="#">
                    <div class="w-full pl-1 py-2 group-hover:bg-indigo-800 rounded duration-150">
                        <div class="flex">
                            <svg class="group-hover:text-white duration-150 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="ml-3 group-hover:text-white flex items-center duration-150">Report</span>
                        </div>
                    </div>
                    </a>
                </div>
            {{-- End SIdebar List --}}
            </div>
            <div class="flex space-x-3 py-2 mb-2 border-t-2 border-indigo-600 border-opacity-80">
                <div class="mx-4 flex items-center">
                    <img class="w-9 rounded-full" src="{{ asset('image/logo.jpg') }}" alt="Profile">
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
            <div class="p-7">
                @yield('content')
            </div>
            {{-- End Content --}}
        </div>
    {{-- End Right Content --}}
    
    

    @include('sweetalert::alert')
    @livewireScripts
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Admin Panel</title>
</head>
<body class="flex bg-gray-100">
    
</body>
</html>