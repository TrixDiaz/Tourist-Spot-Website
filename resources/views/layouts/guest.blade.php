<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-wrap">
        <div class="flex w-full flex-col md:w-1/2">

            <div class="lg:w-[28rem] mx-auto my-auto flex flex-col justify-center pt-8 md:justify-start md:px-6 md:pt-0">
                {{ $slot }}
            </div>
        </div>
        <div class="pointer-events-none relative hidden h-screen select-none bg-black md:block md:w-1/2">
            <div class="absolute inset-0 bg-[#19147A]/35 z-10"></div>
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="flex flex-col items-center justify-center">
                    <x-application-logo class="w-48 h-48" />
                    <p class="text-white text-4xl font-extrabold font-poppins uppercase mt-4">Mondragon</p>
                    <p class="text-white text-2xl font-extrabold font-poppins uppercase mt-1">Tourism Website</p>
                    <div class="flex flex-row items-center justify-center space-x-4 mt-16">
                        <p class="text-white text-3xl font-normal font-poppins capitalize">Discover,</p>
                        <p class="text-white text-3xl font-normal font-poppins capitalize">Explore,</p>
                        <p class="text-white text-3xl font-normal font-poppins capitalize">Belong.</p>
                    </div>
                </div>
            </div>
            <img class="absolute inset-0 h-full w-full object-cover" src="/images/login-image.png" />
        </div>
    </div>

</body>

</html>