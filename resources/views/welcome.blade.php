<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="bg-gray-100 py-16 min-h-screen">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <img src="{{ asset('logo-anglo.png') }}" alt="Logo" class="mx-auto h-20 rounded-xl"/>
        <div class="mx-auto max-w-2xl sm:text-center mt-10">
            <h2 class="text-base/7 font-semibold text-indigo-600">Lista</h2>
            <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-balance sm:text-5xl">
                Evento por el Día de la Mujer</p>
        </div>
        <livewire:users-list class="mt-10"/>
    </div>
</div>
@fluxScripts
</body>
</html>
