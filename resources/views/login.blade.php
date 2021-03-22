<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <title>Login</title>
</head>
<body class="bg-gray-100">

    <div class="w-full h-screen flex justify-center items-center">
        <div class="w-1/4 bg-white rounded-lg shadow-2xl">
            <div class="border-b-2 border-gray-500 p-4 border-opacity-50">
                <span class="flex justify-center text-3xl font-semibold">Login</span>
            </div>
            <form method="POST" action="/auth">
                @csrf
                <div class="flex flex-col p-4">
                    @if (session('gagal'))
                        <span class="text-center text-red-500">{{ session('gagal') }}</span>
                    @endif
                    <label for="email" class="mb-1 font-semibold">Email</label>
                    <input name="email" class="bg-gray-50 focus:ring-blue-500 focus:outline-none bg-opacity-75 rounded-lg ring-2 ring-gray-200 pl-2 p-1" value="{{ old('email') }}" type="text" id="email">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <label for="password" class="mb-1 mt-5 font-semibold">Password</label>
                    <input name="password" class="bg-gray-50 focus:ring-blue-500 focus:outline-none bg-opacity-75 rounded-lg ring-2 ring-gray-200 pl-2 p-1" type="password" id="password">
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-center m-3">
                    <button class="px-20 py-2 focus:bg-blue-600 hover:bg-blue-600 duration-200 rounded-lg bg-blue-400 text-white font-bold">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>