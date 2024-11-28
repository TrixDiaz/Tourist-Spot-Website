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

    <style>
        /*---------------------*\
    #Custom Scrollable side   
\*----------------------*/
        /* The whole scrollbar */
        ::-webkit-scrollbar {
            width: 0.3rem;
        }

        /* The whole Scrollbar Track / Vertical Track */
        ::-webkit-scrollbar-track {
            background: #64748b;
        }

        /* The scrollbar thumb or the hand on track */
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(#3b82f6, #1e40af);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <livewire:layout.navigation />

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>