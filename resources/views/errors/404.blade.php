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
    <div class="flex flex-col justify-center h-screen w-full items-center">
        <p class="text-2xl font-semibold">Oops... Halaman Tidak ada :3</p>
        <a class="mt-5 animate-bounce" href="/">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 text-gray-500 hover:text-blue-500 py-1 duration-150" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
            </svg>
        </a>
    </div>
</body>
</html>