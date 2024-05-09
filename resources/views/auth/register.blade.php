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
<body class="flex flex-col min-h-screen bg-yellow-50">
<div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl">
    <!-- Logo -->
    <a class="text-xl" href="/" >
        <img id="logo-img" src="{{ asset('logo-lightmode.png') }}" alt="Logo Claro" class="mb-8">
    </a>
    <div class="w-full max-w-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <form method="POST" action="{{ route('register') }}" class="bg-white shadow-md rounded px-8 pt-2 mb-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"/>
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            <!-- Cliente Info -->
            <div class="mt-4">
                <x-input-label for="dir_cliente" :value="__('Client Address')"/>
                <x-text-input id="dir_cliente" class="block mt-1 w-full" type="text" name="dir_cliente" :value="old('dir_cliente')" required/>
                <x-input-error :messages="$errors->get('dir_cliente')" class="mt-2"/>
            </div>

            <div class="mt-4">
                <x-input-label for="tlf_cliente" :value="__('Client Phone')"/>
                <x-text-input id="tlf_cliente" class="block mt-1 w-full" type="text" name="tlf_cliente" :value="old('tlf_cliente')" required/>
                <x-input-error :messages="$errors->get('tlf_cliente')" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
