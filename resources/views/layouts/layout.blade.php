<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Página Web</title>
    <!-- Agrega enlaces a tus archivos CSS -->
    @vite("resources/css/app.css")
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.1/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex flex-col min-h-screen">
<x-layout.header />
<main class="flex-grow">
    @section('buscador')
        <x-layout.buscador />
    @show
    @yield("contenido")
        @section('footer')
            <x-layout.footer />
        @show
</main>
<!-- Agrega enlaces a tus archivos JavaScript -->
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
