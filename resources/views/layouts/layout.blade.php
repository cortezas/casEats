<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>
    <!-- Agrega enlaces a tus archivos CSS -->
    @vite("resources/css/app.css")
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.1/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen">
<x-layout.header />
<!--<x-layout.footer />-->
<x-layout.buscador />
<main class="flex-grow">
    @yield("buscadores")

    @yield("contenido")
</main>
<!-- Agrega enlaces a tus archivos JavaScript -->
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
