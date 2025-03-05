<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evento</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [data-flux-label] {
            font-size: 1.125rem;
            line-height: 1.75rem;
            padding-bottom: 0.5rem;
        }

        [data-flux-button] {
            font-size: 1.125rem;
            line-height: 1.75rem;
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
            height: 4rem;
        }

        [data-flux-control] {
            font-size: 1.5rem;
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
            height: 4rem;
            line-height: 2.25rem;
        }
    </style>
</head>
<body>
<div class="bg-gray-100 py-16 min-h-screen">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <img src="{{ asset('logo-anglo.png') }}" alt="Logo" class="mx-auto h-20 rounded-xl"/>
        <div class="mx-auto max-w-2xl sm:text-center mt-10">
            <h1 class="text-base/7 font-semibold text-indigo-600">Lista</h1>
            <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-balance sm:text-5xl">
                Evento por el Día de la Mujer</p>
        </div>
        <livewire:users-list/>
    </div>
</div>
@fluxScripts
</body>
</html>
