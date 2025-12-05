<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <title>Formulario de Solicitud</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font -->
        <script src="https://kit.fontawesome.com/e2d71e4ca2.js" crossorigin="anonymous"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
</head>

<body class="p-10">

    @if (session('success'))
        <x-toast type="success">
            {{ session('success') }}
        </x-toast>
        
    @endif

    @if (session('error'))
    <x-toast type="danger">
        {{ session('eror') }}
    </x-toast>
        
    @endif

    <form action="{{ route('solicitudes.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
    <input type="text" name="nombre" placeholder="Ingrese su nombre" class="border p-2 w-full" value="{{ old('nombre') }}">
    <input type="text" name="apellido" placeholder="Ingrese su apellido" class="border p-2 w-full" value="{{ old('apellido') }}">
    <input type="email" name="email" placeholder="Ingrese su email" class="border p-2 w-full" value="{{ old('email') }}">
    <input type="text" name="telefono" placeholder="Ingrese su teléfono" class="border p-2 w-full" value="{{ old('telefono') }}">
    <input type="text" name="cui" placeholder="Ingrese su cui" class="border p-2 w-full" value="{{ old('cui') }}">
    <input type="text" name="domicilio" placeholder="Ingrese su domicilio" class="border p-2 w-full" value="{{ old('domicilio') }}">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2">
        Enviar
    </button>
    </form>




        @stack('modals')

        @livewireScripts
</body>
</html>