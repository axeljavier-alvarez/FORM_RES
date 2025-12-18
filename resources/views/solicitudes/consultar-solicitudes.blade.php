<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <title>Consulta de solicitud</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font -->
        <script src="https://kit.fontawesome.com/e2d71e4ca2.js" crossorigin="anonymous"></script>
        <link rel="icon" href="{{ asset('imagenes/icono_muni.png') }}">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Para lo de la bandera -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css" />

        <!-- Styles -->
        @livewireStyles
</head>

<body>
<div class="px-4 md:px-8">
        <div class="max-w-4xl mx-auto mt-16 mb-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-[#030EA7] mb-4">
            Constancia de residencia
        </h1>

        <p class="text-[#4B5563] text-base md:text-lg font-bold">
                            Acá podrá verificar el estado de la solicitud de residencia que solicitó.
        </p>

       

     




        
        </div>
</div>
        
        

                <livewire:consultar-solicitud />




        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js">
        </script>
</body>
</html>