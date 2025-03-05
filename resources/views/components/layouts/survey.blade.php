<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Encuesta</title>

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
            color: white;
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

        [data-flux-error] {
            color: orange;
            font-size: 1.125rem;
        }

        body {
            background: url('{{ asset("background-survey.jpg") }}') no-repeat center center fixed;
            background-size: cover;
        }

    </style>
</head>
<body>
<div class="min-h-screen flex flex-col py-16 text-white">
    <div class="lg:px-8 mx-auto px-6">
        <div class="mx-auto max-w-2xl sm:text-center mt-40">
            <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight sm:text-balance sm:text-5xl">
                {{ $title ?? 'Evento por el Día de la Mujer' }}
            </p>
        </div>
    </div>
    {{ $slot }}
</div>
@fluxScripts
</body>
</html>
